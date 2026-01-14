<?php

namespace App\Services;

use App\Models\Ticket;

/**
 * Service for ticket validation logic
 */
class TicketValidationService
{
    /**
     * Validate a ticket by QR code
     */
    public function validateTicket(string $qrCode): array
    {
        $ticket = Ticket::where('qr_code', $qrCode)->first();
        $result = ['valid' => false];

        if (! $ticket) {
            $result['message'] = 'Tiket tidak ditemukan';
        } elseif (! $ticket->isValid()) {
            $result['message'] = 'Tiket tidak valid: '.$this->getInvalidReason($ticket);
            $result['ticket'] = $ticket;
        } elseif (! $ticket->canBeUsed()) {
            $result['message'] = 'Tiket belum atau sudah melewati tanggal keberangkatan';
            $result['ticket'] = $ticket;
        } else {
            $result = [
                'valid' => true,
                'message' => 'Tiket valid dan dapat digunakan',
                'ticket' => $ticket->load([
                    'order.schedule.route.origin',
                    'order.schedule.route.destination',
                    'order.schedule.ship',
                    'passenger',
                ]),
            ];
        }

        return $result;
    }

    /**
     * Mark ticket as used
     */
    public function useTicket(Ticket $ticket, ?string $usedBy = null): array
    {
        if (! $ticket->isValid()) {
            return [
                'success' => false,
                'message' => 'Tiket tidak valid: '.$this->getInvalidReason($ticket),
            ];
        }

        if (! $ticket->canBeUsed()) {
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
    public function getInvalidReason(Ticket $ticket): string
    {
        return match (true) {
            $ticket->status === 'used' => 'Tiket sudah digunakan pada '.$ticket->used_at->format('d/m/Y H:i'),
            $ticket->status === 'cancelled' => 'Tiket telah dibatalkan',
            $ticket->status === 'expired' => 'Tiket sudah kadaluarsa',
            $ticket->valid_until && $ticket->valid_until < now() => 'Tiket sudah melewati masa berlaku',
            default => 'Status tiket tidak valid',
        };
    }
}
