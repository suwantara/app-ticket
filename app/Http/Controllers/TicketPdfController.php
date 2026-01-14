<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\TicketService;
use App\Services\TicketPdfService;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Ticket;

class TicketPdfController extends Controller
{
    private const ACCESS_DENIED_MESSAGE = 'Anda tidak memiliki akses ke tiket ini';

    protected TicketService $ticketService;
    protected TicketPdfService $pdfService;

    public function __construct(TicketService $ticketService, TicketPdfService $pdfService)
    {
        $this->ticketService = $ticketService;
        $this->pdfService = $pdfService;
    }

    /**
     * Download PDF ticket
     */
    public function download(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Verify access - either by email or authenticated user
        if (! $this->canAccessTicket($request, $order)) {
            abort(403, self::ACCESS_DENIED_MESSAGE);
        }

        // Check if order is paid
        if (! $order->isPaid()) {
            abort(400, 'Pesanan belum dibayar');
        }

        // Check if tickets exist
        if (! $order->tickets()->exists()) {
            // Generate tickets if not exist
            $this->ticketService->generateTicketsForOrder($order);
        }

        Log::info('PDF ticket downloaded', [
            'order_number' => $order->order_number,
            'ip' => $request->ip(),
        ]);

        return $this->pdfService->downloadPdf($order);
    }

    /**
     * View PDF ticket in browser
     */
    public function view(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Verify access
        if (! $this->canAccessTicket($request, $order)) {
            abort(403, self::ACCESS_DENIED_MESSAGE);
        }

        // Check if order is paid
        if (! $order->isPaid()) {
            abort(400, 'Pesanan belum dibayar');
        }

        // Check if tickets exist
        if (! $order->tickets()->exists()) {
            $this->ticketService->generateTicketsForOrder($order);
        }

        return $this->pdfService->streamPdf($order);
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
        if (! $this->canAccessTicket($request, $order)) {
            abort(403, self::ACCESS_DENIED_MESSAGE);
        }

        // Load relationships
        $order->load([
            'schedule.route.origin',
            'schedule.route.destination',
            'schedule.ship',
        ]);

        // Generate QR as PNG base64 using chillerlan (GD-based)
        $qrContent = json_encode([
            'ticket_number' => $ticket->ticket_number,
            'qr_code' => $ticket->qr_code,
        ]);

        $options = new QROptions([
            'outputType' => 'png',
            'eccLevel' => EccLevel::H,
            'scale' => 10,
            'imageBase64' => true,
        ]);

        $qrcode = new QRCode($options);
        $ticket->qr_base64 = $qrcode->render($qrContent);

        $pdf = Pdf::loadView('pdf.ticket', [
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
        $isAdminOrStaff = Auth::check() && in_array(Auth::user()->role, ['admin', 'staff']);

        // Check by email in query string (for email links)
        $email = $request->query('email');
        $hasValidEmail = $email && $order->contact_email === $email;

        // Check by token (for secure links)
        $token = $request->query('token');
        $hasValidToken = $token && $this->verifyToken($order, $token);

        // If accessed from booking confirmation page (session check)
        $hasValidSession = session('completed_order') === $order->order_number;

        return $isAdminOrStaff || $hasValidEmail || $hasValidToken || $hasValidSession;
    }

    /**
     * Verify download token
     */
    protected function verifyToken(Order $order, string $token): bool
    {
        $expectedToken = hash('sha256', $order->order_number.$order->contact_email.config('app.key'));

        return hash_equals($expectedToken, $token);
    }

    /**
     * Generate secure download token for order
     */
    public static function generateToken(Order $order): string
    {
        return hash('sha256', $order->order_number.$order->contact_email.config('app.key'));
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
