<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransService
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;

        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Create Snap payment token for an order
     */
    public function createSnapToken(Order $order): array
    {
        $order->load(['schedule.route.origin', 'schedule.route.destination', 'schedule.ship', 'passengers']);

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->contact_name,
                'email' => $order->contact_email,
                'phone' => $order->contact_phone,
            ],
            'item_details' => $this->buildItemDetails($order),
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'hours',
                'duration' => 2,
            ],
            'callbacks' => [
                'finish' => route('payment.finish', $order),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Update order with payment token
            $order->update([
                'payment_token' => $snapToken,
                'payment_url' => $this->getSnapRedirectUrl($snapToken),
            ]);

            return [
                'success' => true,
                'snap_token' => $snapToken,
                'redirect_url' => $this->getSnapRedirectUrl($snapToken),
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: '.$e->getMessage(), [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ]);

            return [
                'success' => false,
                'message' => 'Gagal membuat token pembayaran: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Build item details for Midtrans
     */
    protected function buildItemDetails(Order $order): array
    {
        $items = [];

        // Main ticket item
        $routeName = $order->schedule->route->origin->name.' → '.$order->schedule->route->destination->name;
        $items[] = [
            'id' => 'TICKET-'.$order->schedule_id,
            'price' => (int) ($order->total_amount / $order->passenger_count),
            'quantity' => $order->passenger_count,
            'name' => substr("Tiket {$routeName}", 0, 50), // Max 50 chars
        ];

        return $items;
    }

    /**
     * Get Snap redirect URL
     */
    protected function getSnapRedirectUrl(string $token): string
    {
        $baseUrl = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v2/vtweb/'
            : 'https://app.sandbox.midtrans.com/snap/v2/vtweb/';

        return $baseUrl.$token;
    }

    /**
     * Handle payment notification from Midtrans
     */
    public function handleNotification(): array
    {
        try {
            $notification = new Notification;

            $orderNumber = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $fraudStatus = $notification->fraud_status ?? null;

            Log::info('Midtrans Notification Received', [
                'order_id' => $orderNumber,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'fraud_status' => $fraudStatus,
            ]);

            $order = Order::where('order_number', $orderNumber)->first();

            if (! $order) {
                Log::error('Order not found for notification', ['order_number' => $orderNumber]);

                return ['success' => false, 'message' => 'Order not found'];
            }

            // Process based on transaction status
            $this->processTransactionStatus($order, $transactionStatus, $paymentType, $fraudStatus);

            return [
                'success' => true,
                'order_number' => $orderNumber,
                'status' => $transactionStatus,
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: '.$e->getMessage());

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Process transaction status from Midtrans
     */
    protected function processTransactionStatus(Order $order, string $status, string $paymentType, ?string $fraudStatus): void
    {
        switch ($status) {
            case 'capture':
                // For credit card, check fraud status
                if ($paymentType === 'credit_card') {
                    if ($fraudStatus === 'accept') {
                        $this->markOrderAsPaid($order, $paymentType);
                    } elseif ($fraudStatus === 'challenge') {
                        $order->update([
                            'payment_status' => 'pending',
                            'payment_method' => $paymentType,
                            'notes' => 'Transaction challenged, waiting for review',
                        ]);
                    }
                } else {
                    $this->markOrderAsPaid($order, $paymentType);
                }
                break;

            case 'settlement':
                $this->markOrderAsPaid($order, $paymentType);
                break;

            case 'pending':
                $order->update([
                    'payment_status' => 'pending',
                    'payment_method' => $paymentType,
                ]);
                break;

            case 'deny':
            case 'cancel':
                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'failed',
                    'payment_method' => $paymentType,
                ]);
                break;

            case 'expire':
                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'expired',
                    'payment_method' => $paymentType,
                ]);
                break;

            case 'refund':
            case 'partial_refund':
                $order->update([
                    'status' => 'refunded',
                    'payment_status' => 'refunded',
                ]);
                break;

            default:
                Log::warning('Unhandled Midtrans transaction status', [
                    'order_number' => $order->order_number,
                    'status' => $status,
                    'payment_type' => $paymentType,
                ]);
                break;
        }
    }

    /**
     * Mark order as paid
     */
    protected function markOrderAsPaid(Order $order, string $paymentType): void
    {
        $order->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'payment_method' => $paymentType,
            'paid_at' => now(),
        ]);

        Log::info('Order marked as paid', [
            'order_number' => $order->order_number,
            'payment_method' => $paymentType,
        ]);

        // Generate tickets after payment success
        $this->generateTicketsForOrder($order);
    }

    /**
     * Generate tickets for paid order
     */
    protected function generateTicketsForOrder(Order $order): void
    {
        try {
            $result = $this->ticketService->generateTicketsForOrder($order);

            if ($result['success']) {
                Log::info('Tickets generated successfully', [
                    'order_number' => $order->order_number,
                    'ticket_count' => count($result['tickets'] ?? []),
                ]);
            } else {
                Log::error('Failed to generate tickets', [
                    'order_number' => $order->order_number,
                    'message' => $result['message'],
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception while generating tickets', [
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get transaction status from Midtrans
     */
    public function getTransactionStatus(string $orderNumber): array
    {
        try {
            $status = \Midtrans\Transaction::status($orderNumber);

            return [
                'success' => true,
                'data' => $status,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get client key for frontend
     */
    public function getClientKey(): string
    {
        return config('midtrans.client_key');
    }

    /**
     * Get Snap JS URL
     */
    public function getSnapJsUrl(): string
    {
        return config('midtrans.snap_url');
    }
}
