<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\TicketService;
use Illuminate\Console\Command;

class GenerateTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:generate {order? : The order ID or order number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate tickets for a paid order';

    /**
     * Execute the console command.
     */
    public function handle(TicketService $ticketService)
    {
        $orderInput = $this->argument('order');

        if ($orderInput) {
            return $this->handleSingleOrder($ticketService, $orderInput);
        }

        return $this->handleAllPendingOrders($ticketService);
    }

    protected function handleSingleOrder(TicketService $ticketService, string $orderInput): int
    {
        $order = Order::where('id', $orderInput)
            ->orWhere('order_number', $orderInput)
            ->first();

        if (! $order) {
            $this->error("Order not found: {$orderInput}");

            return 1;
        }

        return $this->generateForOrder($ticketService, $order);
    }

    protected function handleAllPendingOrders(TicketService $ticketService): int
    {
        $orders = Order::where('payment_status', 'paid')
            ->whereDoesntHave('tickets')
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No paid orders without tickets found.');

            return 0;
        }

        $this->info("Found {$orders->count()} orders to process...");

        foreach ($orders as $order) {
            $this->generateForOrder($ticketService, $order);
        }

        $this->info('Done!');

        return 0;
    }

    protected function generateForOrder(TicketService $ticketService, Order $order): int
    {
        if (! $order->isPaid()) {
            $this->warn("Order {$order->order_number} is not paid. Skipping...");

            return 1;
        }

        $this->info("Generating tickets for order: {$order->order_number}");

        $result = $ticketService->generateTicketsForOrder($order);

        if ($result['success']) {
            $ticketCount = count($result['tickets'] ?? []);
            $this->info("✓ Generated {$ticketCount} tickets");

            foreach ($result['tickets'] as $ticket) {
                $this->line("  - {$ticket->ticket_number} ({$ticket->passenger->name})");
            }

            return 0;
        } else {
            $this->error("✗ {$result['message']}");

            return 1;
        }
    }
}
