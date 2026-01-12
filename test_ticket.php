<?php

// Script untuk testing generate ticket
// Jalankan: php test_ticket.php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use App\Services\TicketService;

echo "=== Testing Ticket Generation ===" . PHP_EOL;

$order = Order::with(['passengers', 'schedule'])->first();

if (!$order) {
    echo "No orders found!" . PHP_EOL;
    exit(1);
}

echo "Order: {$order->order_number}" . PHP_EOL;
echo "Current Status: {$order->payment_status}" . PHP_EOL;
echo "Passengers: {$order->passengers->count()}" . PHP_EOL;

// Mark as paid for testing
$order->update([
    'payment_status' => 'paid',
    'status' => 'confirmed',
    'paid_at' => now(),
]);

echo "Updated order to PAID" . PHP_EOL;

// Generate tickets
$ticketService = app(TicketService::class);
$result = $ticketService->generateTicketsForOrder($order);

if ($result['success']) {
    echo PHP_EOL . "SUCCESS! Tickets generated:" . PHP_EOL;
    foreach ($result['tickets'] as $ticket) {
        echo "  - {$ticket->ticket_number} for {$ticket->passenger->name}" . PHP_EOL;
        echo "    QR Code: {$ticket->qr_code}" . PHP_EOL;
        echo "    QR Path: " . ($ticket->qr_code_path ?? 'Not generated') . PHP_EOL;
    }
} else {
    echo "FAILED: {$result['message']}" . PHP_EOL;
}

echo PHP_EOL . "Test complete!" . PHP_EOL;
