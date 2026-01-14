<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

/**
 * Service for generating ticket PDFs
 */
class TicketPdfService
{
    public function __construct(protected QrCodeService $qrCodeService)
    {
    }

    /**
     * Generate PDF for order with all tickets
     */
    public function generatePdf(Order $order): \Barryvdh\DomPDF\PDF
    {
        $order->load([
            'schedule.route.origin',
            'schedule.route.destination',
            'schedule.ship',
            'tickets.passenger',
        ]);

        $tickets = $order->tickets->map(function ($ticket) {
            // Generate QR as PNG base64 using QrCodeService
            $ticket->qr_base64 = $this->qrCodeService->generateBase64Png($ticket);

            return $ticket;
        });

        $pdf = Pdf::loadView('pdf.ticket', [
            'order' => $order,
            'tickets' => $tickets,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    /**
     * Generate and save PDF to storage
     */
    public function generateAndSavePdf(Order $order): string
    {
        $pdf = $this->generatePdf($order);

        $filename = "tickets/order-{$order->order_number}.pdf";

        Storage::disk('public')->put($filename, $pdf->output());

        return $filename;
    }

    /**
     * Get PDF download response
     */
    public function downloadPdf(Order $order): Response
    {
        $pdf = $this->generatePdf($order);

        $filename = "tiket-{$order->order_number}.pdf";

        return $pdf->download($filename);
    }

    /**
     * Stream PDF in browser
     */
    public function streamPdf(Order $order): Response
    {
        $pdf = $this->generatePdf($order);

        $filename = "tiket-{$order->order_number}.pdf";

        return $pdf->stream($filename);
    }
}
