<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Ticket;
use App\Models\Passenger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketService
{
    /**
     * Generate tickets for all passengers in an order
     */
    public function generateTicketsForOrder(Order $order): array
    {
        // Check if order is paid
        if (!$order->isPaid()) {
            return [
                'success' => false,
                'message' => 'Order belum dibayar',
            ];
        }

        // Check if tickets already generated
        if ($order->tickets()->exists()) {
            return [
                'success' => true,
                'message' => 'Tiket sudah dibuat sebelumnya',
                'tickets' => $order->tickets,
            ];
        }

        $order->load(['passengers', 'schedule']);
        $tickets = [];

        try {
            foreach ($order->passengers as $passenger) {
                $ticket = $this->createTicketForPassenger($order, $passenger);
                $tickets[] = $ticket;
            }

            Log::info('Tickets generated for order', [
                'order_number' => $order->order_number,
                'ticket_count' => count($tickets),
            ]);

            return [
                'success' => true,
                'message' => 'Tiket berhasil dibuat',
                'tickets' => $tickets,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to generate tickets', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal membuat tiket: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Create a single ticket for a passenger
     */
    protected function createTicketForPassenger(Order $order, Passenger $passenger): Ticket
    {
        // Create ticket
        $ticket = Ticket::create([
            'order_id' => $order->id,
            'passenger_id' => $passenger->id,
            'status' => 'active',
            'valid_from' => $order->travel_date->startOfDay(),
            'valid_until' => $order->travel_date->endOfDay(),
        ]);

        // Generate QR code image
        $qrCodePath = $this->generateQrCodeImage($ticket);
        
        if ($qrCodePath) {
            $ticket->update(['qr_code_path' => $qrCodePath]);
        }

        return $ticket->fresh();
    }

    /**
     * Generate QR code image and save to storage
     */
    public function generateQrCodeImage(Ticket $ticket): ?string
    {
        try {
            // Create directory if not exists
            $directory = 'tickets/qrcodes';
            Storage::disk('public')->makeDirectory($directory);

            // Generate QR code content (JSON with ticket info)
            $qrContent = json_encode([
                'ticket_number' => $ticket->ticket_number,
                'qr_code' => $ticket->qr_code,
                'order_number' => $ticket->order->order_number,
            ]);

            // Generate QR code as SVG (more compatible, doesn't need Imagick)
            $qrCode = QrCode::size(300)
                ->errorCorrection('H')
                ->margin(1)
                ->generate($qrContent);

            // Save to storage as SVG
            $filename = "{$directory}/{$ticket->qr_code}.svg";
            Storage::disk('public')->put($filename, $qrCode);

            return $filename;
        } catch (\Exception $e) {
            Log::error('Failed to generate QR code image', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    /**
     * Generate QR code as SVG (for inline display)
     */
    public function generateQrCodeSvg(Ticket $ticket): string
    {
        $qrContent = json_encode([
            'ticket_number' => $ticket->ticket_number,
            'qr_code' => $ticket->qr_code,
            'order_number' => $ticket->order->order_number,
        ]);

        return QrCode::size(200)
            ->errorCorrection('H')
            ->margin(1)
            ->generate($qrContent);
    }

    /**
     * Validate a ticket by QR code
     */
    public function validateTicket(string $qrCode): array
    {
        $ticket = Ticket::where('qr_code', $qrCode)->first();

        if (!$ticket) {
            return [
                'valid' => false,
                'message' => 'Tiket tidak ditemukan',
            ];
        }

        // Check ticket validity
        if (!$ticket->isValid()) {
            return [
                'valid' => false,
                'message' => 'Tiket tidak valid: ' . $this->getInvalidReason($ticket),
                'ticket' => $ticket,
            ];
        }

        // Check if can be used today
        if (!$ticket->canBeUsed()) {
            return [
                'valid' => false,
                'message' => 'Tiket belum atau sudah melewati tanggal keberangkatan',
                'ticket' => $ticket,
            ];
        }

        return [
            'valid' => true,
            'message' => 'Tiket valid dan dapat digunakan',
            'ticket' => $ticket->load(['order.schedule.route.origin', 'order.schedule.route.destination', 'order.schedule.ship', 'passenger']),
        ];
    }

    /**
     * Mark ticket as used
     */
    public function useTicket(Ticket $ticket, ?string $usedBy = null): array
    {
        if (!$ticket->isValid()) {
            return [
                'success' => false,
                'message' => 'Tiket tidak valid: ' . $this->getInvalidReason($ticket),
            ];
        }

        if (!$ticket->canBeUsed()) {
            return [
                'success' => false,
                'message' => 'Tiket belum atau sudah melewati tanggal keberangkatan',
            ];
        }

        $ticket->markAsUsed($usedBy);

        return [
            'success' => true,
            'message' => 'Tiket berhasil digunakan',
            'ticket' => $ticket->fresh(),
        ];
    }

    /**
     * Get reason why ticket is invalid
     */
    protected function getInvalidReason(Ticket $ticket): string
    {
        if ($ticket->status === 'used') {
            return 'Tiket sudah digunakan pada ' . $ticket->used_at->format('d/m/Y H:i');
        }

        if ($ticket->status === 'cancelled') {
            return 'Tiket telah dibatalkan';
        }

        if ($ticket->status === 'expired') {
            return 'Tiket sudah kadaluarsa';
        }

        if ($ticket->valid_until && $ticket->valid_until < now()) {
            return 'Tiket sudah melewati masa berlaku';
        }

        return 'Status tiket tidak valid';
    }

    /**
     * Get ticket by ticket number
     */
    public function getByTicketNumber(string $ticketNumber): ?Ticket
    {
        return Ticket::where('ticket_number', $ticketNumber)
            ->with(['order.schedule.route.origin', 'order.schedule.route.destination', 'order.schedule.ship', 'passenger'])
            ->first();
    }

    /**
     * Get ticket by QR code
     */
    public function getByQrCode(string $qrCode): ?Ticket
    {
        return Ticket::where('qr_code', $qrCode)
            ->with(['order.schedule.route.origin', 'order.schedule.route.destination', 'order.schedule.ship', 'passenger'])
            ->first();
    }

    /**
     * Get all tickets for an order
     */
    public function getTicketsForOrder(Order $order): \Illuminate\Database\Eloquent\Collection
    {
        return $order->tickets()
            ->with(['passenger'])
            ->get();
    }

    /**
     * Cancel all tickets for an order
     */
    public function cancelTicketsForOrder(Order $order): int
    {
        return $order->tickets()
            ->where('status', 'active')
            ->update([
                'status' => 'cancelled',
                'notes' => 'Dibatalkan karena order dibatalkan',
            ]);
    }

    /**
     * Check and expire old tickets
     */
    public function expireOldTickets(): int
    {
        return Ticket::where('status', 'active')
            ->whereNotNull('valid_until')
            ->where('valid_until', '<', now())
            ->update([
                'status' => 'expired',
                'notes' => 'Otomatis kadaluarsa',
            ]);
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
            // Generate QR as SVG and convert to base64 data URI for DOMPDF compatibility
            $qrContent = json_encode([
                'ticket_number' => $ticket->ticket_number,
                'qr_code' => $ticket->qr_code,
            ]);
            
            // Generate SVG QR code (doesn't require imagick)
            $qrSvg = QrCode::format('svg')
                ->size(200)
                ->errorCorrection('H')
                ->margin(1)
                ->generate($qrContent);
            
            // Convert SVG to base64 data URI
            $ticket->qr_base64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
            
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
    public function downloadPdf(Order $order): \Symfony\Component\HttpFoundation\Response
    {
        $pdf = $this->generatePdf($order);
        
        $filename = "tiket-{$order->order_number}.pdf";
        
        return $pdf->download($filename);
    }

    /**
     * Stream PDF in browser
     */
    public function streamPdf(Order $order): \Symfony\Component\HttpFoundation\Response
    {
        $pdf = $this->generatePdf($order);
        
        $filename = "tiket-{$order->order_number}.pdf";
        
        return $pdf->stream($filename);
    }
}
