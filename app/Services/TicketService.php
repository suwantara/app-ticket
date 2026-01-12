<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Passenger;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Core ticket operations service
 * Delegates QR generation to QrCodeService, PDF to TicketPdfService, validation to TicketValidationService
 */
class TicketService
{
    public function __construct(
        protected QrCodeService $qrCodeService,
        protected TicketValidationService $validationService
    ) {}

    /**
     * Generate tickets for all passengers in an order
     */
    public function generateTicketsForOrder(Order $order): array
    {
        $result = [];

        // Check if order is paid
        if (! $order->isPaid()) {
            $result = [
                'success' => false,
                'message' => 'Order belum dibayar',
            ];
        } elseif ($order->tickets()->exists()) {
            // Check if tickets already generated
            $result = [
                'success' => true,
                'message' => 'Tiket sudah dibuat sebelumnya',
                'tickets' => $order->tickets,
            ];
        } else {
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

                $result = [
                    'success' => true,
                    'message' => 'Tiket berhasil dibuat',
                    'tickets' => $tickets,
                ];
            } catch (\Exception $e) {
                Log::error('Failed to generate tickets', [
                    'order_number' => $order->order_number,
                    'error' => $e->getMessage(),
                ]);

                $result = [
                    'success' => false,
                    'message' => 'Gagal membuat tiket: '.$e->getMessage(),
                ];
            }
        }

        return $result;
    }

    /**
     * Create a single ticket for a passenger
     */
    protected function createTicketForPassenger(Order $order, Passenger $passenger): Ticket
    {
        $ticket = Ticket::create([
            'order_id' => $order->id,
            'passenger_id' => $passenger->id,
            'status' => 'active',
            'valid_from' => $order->travel_date->startOfDay(),
            'valid_until' => $order->travel_date->endOfDay(),
        ]);

        // Generate QR code image using QrCodeService
        $qrCodePath = $this->qrCodeService->generateImage($ticket);

        if ($qrCodePath) {
            $ticket->update(['qr_code_path' => $qrCodePath]);
        }

        return $ticket->fresh();
    }

    /**
     * Validate a ticket by QR code
     * Delegates to TicketValidationService
     */
    public function validateTicket(string $qrCode): array
    {
        return $this->validationService->validateTicket($qrCode);
    }

    /**
     * Mark ticket as used
     * Delegates to TicketValidationService
     */
    public function useTicket(Ticket $ticket, ?string $usedBy = null): array
    {
        return $this->validationService->useTicket($ticket, $usedBy);
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
    public function getTicketsForOrder(Order $order): Collection
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
}
