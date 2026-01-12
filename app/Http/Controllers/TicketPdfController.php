<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TicketPdfController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Download PDF ticket
     */
    public function download(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Verify access - either by email or authenticated user
        if (!$this->canAccessTicket($request, $order)) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini');
        }

        // Check if order is paid
        if (!$order->isPaid()) {
            abort(400, 'Pesanan belum dibayar');
        }

        // Check if tickets exist
        if (!$order->tickets()->exists()) {
            // Generate tickets if not exist
            $this->ticketService->generateTicketsForOrder($order);
        }

        Log::info('PDF ticket downloaded', [
            'order_number' => $order->order_number,
            'ip' => $request->ip(),
        ]);

        return $this->ticketService->downloadPdf($order);
    }

    /**
     * View PDF ticket in browser
     */
    public function view(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Verify access
        if (!$this->canAccessTicket($request, $order)) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini');
        }

        // Check if order is paid
        if (!$order->isPaid()) {
            abort(400, 'Pesanan belum dibayar');
        }

        // Check if tickets exist
        if (!$order->tickets()->exists()) {
            $this->ticketService->generateTicketsForOrder($order);
        }

        return $this->ticketService->streamPdf($order);
    }

    /**
     * Download single ticket PDF
     */
    public function downloadSingle(Request $request, string $ticketNumber)
    {
        $ticket = \App\Models\Ticket::where('ticket_number', $ticketNumber)
            ->with(['order', 'passenger'])
            ->firstOrFail();

        $order = $ticket->order;

        // Verify access
        if (!$this->canAccessTicket($request, $order)) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini');
        }

        // Load relationships
        $order->load([
            'schedule.route.origin',
            'schedule.route.destination',
            'schedule.ship',
        ]);

        // Generate QR SVG
        $ticket->qr_svg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
            ->size(150)
            ->errorCorrection('H')
            ->generate($ticket->qr_code);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.ticket', [
            'order' => $order,
            'tickets' => collect([$ticket]),
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download("tiket-{$ticket->ticket_number}.pdf");
    }

    /**
     * Check if user can access the ticket
     */
    protected function canAccessTicket(Request $request, Order $order): bool
    {
        // If authenticated user is admin or staff, allow access
        if (auth()->check()) {
            $user = auth()->user();
            if (in_array($user->role, ['admin', 'staff'])) {
                return true;
            }
        }

        // Check by email in query string (for email links)
        $email = $request->query('email');
        if ($email && $order->contact_email === $email) {
            return true;
        }

        // Check by token (for secure links)
        $token = $request->query('token');
        if ($token && $this->verifyToken($order, $token)) {
            return true;
        }

        // If accessed from booking confirmation page (session check)
        if (session('completed_order') === $order->order_number) {
            return true;
        }

        return false;
    }

    /**
     * Verify download token
     */
    protected function verifyToken(Order $order, string $token): bool
    {
        $expectedToken = hash('sha256', $order->order_number . $order->contact_email . config('app.key'));
        return hash_equals($expectedToken, $token);
    }

    /**
     * Generate secure download token for order
     */
    public static function generateToken(Order $order): string
    {
        return hash('sha256', $order->order_number . $order->contact_email . config('app.key'));
    }

    /**
     * Get secure download URL for order
     */
    public static function getSecureDownloadUrl(Order $order): string
    {
        $token = self::generateToken($order);
        return route('ticket.pdf.download', [
            'orderNumber' => $order->order_number,
            'token' => $token,
        ]);
    }

    /**
     * Get secure view URL for order
     */
    public static function getSecureViewUrl(Order $order): string
    {
        $token = self::generateToken($order);
        return route('ticket.pdf.view', [
            'orderNumber' => $order->order_number,
            'token' => $token,
        ]);
    }
}
