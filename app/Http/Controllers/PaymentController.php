<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected MidtransService $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * Show payment page with Snap embed
     */
    public function show(Order $order)
    {
        // Check if order can be paid
        if (! $order->canBePaid()) {
            return redirect()->route('booking.confirmation', $order)
                ->with('error', 'Pesanan ini tidak dapat dibayar.');
        }

        // Load relationships
        $order->load(['schedule.route.origin', 'schedule.route.destination', 'schedule.ship', 'passengers']);

        // Get or create snap token
        if (! $order->payment_token) {
            $result = $this->midtrans->createSnapToken($order);

            if (! $result['success']) {
                return redirect()->route('booking.confirmation', $order)
                    ->with('error', $result['message']);
            }
        }

        return view('pages.payment', [
            'order' => $order,
            'snapToken' => $order->payment_token,
            'clientKey' => $this->midtrans->getClientKey(),
            'snapJsUrl' => $this->midtrans->getSnapJsUrl(),
        ]);
    }

    /**
     * Create payment token via AJAX
     */
    public function createToken(Order $order)
    {
        if (! $order->canBePaid()) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan ini tidak dapat dibayar.',
            ], 400);
        }

        $result = $this->midtrans->createSnapToken($order);

        return response()->json($result);
    }

    /**
     * Handle finish redirect from Midtrans
     */
    public function finish(Request $request, Order $order)
    {
        $transactionStatus = $request->get('transaction_status');
        $orderId = $request->get('order_id');

        Log::info('Payment finish redirect', [
            'order_id' => $order->id,
            'transaction_status' => $transactionStatus,
            'midtrans_order_id' => $orderId,
        ]);

        // Refresh order status
        $order->refresh();

        // If transaction_status indicates success, verify with Midtrans and update order
        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            // Verify and update order status directly
            $statusResult = $this->midtrans->getTransactionStatus($order->order_number);

            if ($statusResult['success']) {
                $midtransStatus = $statusResult['data']->transaction_status ?? null;

                if (in_array($midtransStatus, ['settlement', 'capture']) && ! $order->isPaid()) {
                    $order->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_method' => $statusResult['data']->payment_type ?? 'unknown',
                        'paid_at' => now(),
                    ]);
                    $order->refresh();
                }
            }
        }

        // If payment successful, redirect to ticket page
        if ($order->isPaid()) {
            return redirect()->route('ticket.show', $order)
                ->with('success', 'Pembayaran berhasil! E-Ticket Anda sudah siap.');
        }

        // Show appropriate message based on status
        $message = match ($transactionStatus) {
            'pending' => 'Pembayaran sedang diproses. Silakan selesaikan pembayaran.',
            'deny', 'cancel', 'expire' => 'Pembayaran gagal atau dibatalkan.',
            default => 'Status pembayaran: '.($transactionStatus ?? 'unknown'),
        };

        $type = match ($transactionStatus) {
            'pending' => 'warning',
            default => 'error',
        };

        return redirect()->route('booking.confirmation', $order)
            ->with($type, $message);
    }

    /**
     * Handle unfinish redirect from Midtrans
     */
    public function unfinish(Request $request, Order $order)
    {
        Log::info('Payment unfinish redirect', [
            'order_id' => $order->id,
            'request' => $request->all(),
        ]);

        return redirect()->route('payment.show', $order)
            ->with('warning', 'Pembayaran belum selesai. Silakan coba lagi.');
    }

    /**
     * Handle error redirect from Midtrans
     */
    public function error(Request $request, Order $order)
    {
        Log::error('Payment error redirect', [
            'order_id' => $order->id,
            'request' => $request->all(),
        ]);

        return redirect()->route('booking.confirmation', $order)
            ->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
    }

    /**
     * Handle notification webhook from Midtrans
     */
    public function notification(Request $request)
    {
        Log::info('Midtrans notification webhook received', [
            'payload' => $request->all(),
        ]);

        $result = $this->midtrans->handleNotification();

        if ($result['success']) {
            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'error', 'message' => $result['message']], 400);
    }

    /**
     * Check payment status via AJAX
     */
    public function checkStatus(Order $order)
    {
        $order->refresh();

        return response()->json([
            'order_number' => $order->order_number,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'is_paid' => $order->isPaid(),
            'can_pay' => $order->canBePaid(),
        ]);
    }
}
