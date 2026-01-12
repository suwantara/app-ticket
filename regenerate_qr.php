<?php

// Script untuk regenerate QR codes
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Ticket;
use App\Services\TicketService;

echo "=== Regenerating QR Codes ===" . PHP_EOL;

$ticketService = app(TicketService::class);
$tickets = Ticket::whereNull('qr_code_path')->orWhere('qr_code_path', '')->get();

echo "Found {$tickets->count()} tickets without QR code images" . PHP_EOL;

foreach ($tickets as $ticket) {
    echo "Processing: {$ticket->ticket_number}... ";
    $path = $ticketService->generateQrCodeImage($ticket);
    
    if ($path) {
        $ticket->update(['qr_code_path' => $path]);
        echo "OK - {$path}" . PHP_EOL;
    } else {
        echo "FAILED" . PHP_EOL;
    }
}

echo "Done!" . PHP_EOL;
