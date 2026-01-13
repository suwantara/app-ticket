<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use App\Services\MidtransService;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected TicketService $ticketService;

    protected MidtransService $midtransService;

    public function __construct(TicketService $ticketService, MidtransService $midtransService)
    {
        $this->ticketService = $ticketService;
        $this->midtransService = $midtransService;
    }

    /**
     * Display all tickets for an order
     */
    public function show(Order $order)
    {
        // Load order with relations
        $order->load([
            'schedule.route.origin',
            'schedule.route.destination',
            'schedule.ship',
            'passengers',
            'tickets.passenger',
        ]);

        // Check if order is paid - if not, verify with Midtrans first
        if (! $order->isPaid()) {
            // Check payment status directly from Midtrans
            $statusResult = $this->midtransService->getTransactionStatus($order->order_number);

            if ($statusResult['success']) {
                $midtransStatus = $statusResult['data']->transaction_status ?? null;

                // If Midtrans says it's paid, update our database
                if (in_array($midtransStatus, ['settlement', 'capture'])) {
                    $order->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_method' => $statusResult['data']->payment_type ?? 'unknown',
                        'paid_at' => now(),
                    ]);
                    $order->refresh();
                }
            }

            // If still not paid after checking, redirect
            if (! $order->isPaid()) {
                return redirect()->route('payment.show', $order)
                    ->with('error', 'Silakan selesaikan pembayaran terlebih dahulu');
            }
        }

        // Generate tickets if not exist
        if ($order->tickets->isEmpty()) {
            $this->ticketService->generateTicketsForOrder($order);
            $order->load('tickets.passenger');
        }

        return view('tickets.show', compact('order'));
    }

    /**
     * Display a single ticket
     */
    public function showSingle(Ticket $ticket)
    {
        $ticket->load([
            'order.schedule.route.origin',
            'order.schedule.route.destination',
            'order.schedule.ship',
            'passenger',
        ]);

        return view('tickets.single', compact('ticket'));
    }

    /**
     * Download ticket as PDF (placeholder for future implementation)
     */
    public function download(Ticket $ticket)
    {
        // For now, redirect to single ticket view
        // PDF generation can be added later
        return redirect()->route('ticket.single', $ticket);
    }

    /**
     * Validate ticket by QR code (API endpoint for scanning)
     */
    public function validate(string $qrCode): JsonResponse
    {
        $result = $this->ticketService->validateTicket($qrCode);

        return response()->json($result);
    }

    /**
     * Mark ticket as used (API endpoint)
     */
    public function markAsUsed(Request $request, Ticket $ticket): JsonResponse
    {
        $usedBy = $request->input('used_by');
        $result = $this->ticketService->useTicket($ticket, $usedBy);

        return response()->json($result);
    }

    /**
     * Search ticket by ticket number or QR code
     */
    public function search(Request $request)
    {
        // If no query, show the search page
        if (! $request->has('query') || empty($request->input('query'))) {
            return view('tickets.search');
        }

        $request->validate([
            'query' => 'required|string|min:3',
        ]);

        $query = $request->input('query');

        $ticket = Ticket::where('ticket_number', $query)
            ->orWhere('qr_code', $query)
            ->first();

        if ($ticket) {
            return redirect()->route('ticket.single', $ticket);
        }

        // Check if it's an order number
        $order = Order::where('order_number', $query)->first();

        if ($order && $order->isPaid()) {
            return redirect()->route('ticket.show', $order);
        }

        return back()->with('error', 'Tiket tidak ditemukan dengan kode: ' . $query);
    }

    /**
     * Show validation page (for staff)
     */
    public function validationPage()
    {
        return view('tickets.validate');
    }

    /**
     * Process validation from form
     */
    public function processValidation(Request $request): JsonResponse
    {
        $request->validate([
            'qr_code' => 'required|string',
            'action' => 'required|in:validate,use',
        ]);

        $qrCode = $request->input('qr_code');
        $action = $request->input('action');

        if ($action === 'validate') {
            return response()->json($this->ticketService->validateTicket($qrCode));
        }

        // Action = use
        $ticket = Ticket::where('qr_code', $qrCode)->first();

        if (! $ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan',
            ]);
        }

        return response()->json(
            $this->ticketService->useTicket($ticket, $request->user()?->name ?? 'System')
        );
    }
}
