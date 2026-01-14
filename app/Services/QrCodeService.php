<?php

namespace App\Services;

use App\Models\Ticket;
use chillerlan\QRCode\QRCode as ChillerlanQRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Service for generating QR codes for tickets
 */
class QrCodeService
{
    /**
     * Generate QR code content as JSON
     */
    public function getQrContent(Ticket $ticket): string
    {
        return json_encode([
            'ticket_number' => $ticket->ticket_number,
            'qr_code' => $ticket->qr_code,
            'order_number' => $ticket->order->order_number,
        ]);
    }

    /**
     * Generate QR code image and save to storage
     */
    public function generateImage(Ticket $ticket): ?string
    {
        try {
            $directory = 'tickets/qrcodes';
            Storage::disk('public')->makeDirectory($directory);

            $qrContent = $this->getQrContent($ticket);

            // Generate QR code as SVG (more compatible, doesn't need Imagick)
            $qrCode = QrCode::size(300)
                ->errorCorrection('H')
                ->margin(1)
                ->generate($qrContent);

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
     * Generate QR code as SVG string (for inline display)
     */
    public function generateSvg(Ticket $ticket): string
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
     * Generate QR code as base64 PNG (for PDF embedding)
     */
    public function generateBase64Png(Ticket $ticket): string
    {
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

        $qrcode = new ChillerlanQRCode($options);

        return $qrcode->render($qrContent);
    }
}
