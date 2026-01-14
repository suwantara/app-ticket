<?php

namespace App\Services;

use App\Models\Ticket;

/**
 * Service for parsing QR code data from various formats
 */
class QrCodeParserService
{
    /**
     * Extract QR code from scanned data
     * Handles both JSON and plain text formats
     */
    public function extractQrCode(string $data): ?string
    {
        // Try to decode as JSON first
        $decoded = json_decode($data, true);

        if ($decoded) {
            return $this->extractQrCodeFromJson($decoded);
        }

        // If not JSON, try to extract from plain text
        return $this->extractQrCodeFromPlainText($data);
    }

    /**
     * Extract QR code from decoded JSON data
     */
    protected function extractQrCodeFromJson(array $decoded): ?string
    {
        if (isset($decoded['qr_code'])) {
            return $decoded['qr_code'];
        }

        if (isset($decoded['ticket_number'])) {
            $ticket = Ticket::where('ticket_number', $decoded['ticket_number'])->first();

            return $ticket?->qr_code;
        }

        return null;
    }

    /**
     * Extract QR code from plain text data
     */
    protected function extractQrCodeFromPlainText(string $data): ?string
    {
        // Check if it matches QR code pattern (QR + timestamp + random)
        if (preg_match('/^QR\d{14}[A-Z0-9]{8}$/', $data)) {
            return $data;
        }

        // Could also be ticket number
        if (preg_match('/^TKT-\d{8}-[A-Z0-9]{5}$/', $data)) {
            $ticket = Ticket::where('ticket_number', $data)->first();

            return $ticket?->qr_code;
        }

        return null;
    }
}
