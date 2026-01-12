<?php

namespace App\Livewire;

use App\Models\Order;
use App\Services\MidtransService;
use App\Services\TicketService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TicketPage extends Component
{
    public Order $order;

    public bool $isLoading = false;

    public ?string $errorMessage = null;

    public ?string $successMessage = null;

    protected MidtransService $midtransService;

    protected TicketService $ticketService;

    public function boot(MidtransService $midtransService, TicketService $ticketService): void
    {
        $this->midtransService = $midtransService;
        $this->ticketService = $ticketService;
    }

    public function mount(Order $order): void
    {
        // Eager load all relationships to prevent N+1
        $this->order = $order->load([
            'schedule.route.origin',
            'schedule.route.destination',
            'schedule.ship',
            'passengers',
            'tickets.passenger',
        ]);

        $this->checkPaymentStatus();
    }

    public function checkPaymentStatus(): void
    {
        if ($this->order->isPaid()) {
            $this->generateTicketsIfNeeded();

            return;
        }

        $this->isLoading = true;

        try {
            $statusResult = $this->midtransService->getTransactionStatus($this->order->order_number);

            if ($statusResult['success']) {
                $midtransStatus = $statusResult['data']->transaction_status ?? null;

                if (in_array($midtransStatus, ['settlement', 'capture'])) {
                    $this->order->update([
                        'status' => 'confirmed',
                        'payment_status' => 'paid',
                        'payment_method' => $statusResult['data']->payment_type ?? 'unknown',
                        'paid_at' => now(),
                    ]);
                    $this->order->refresh();
                    $this->generateTicketsIfNeeded();
                    $this->successMessage = 'Pembayaran berhasil diverifikasi!';
                }
            }
        } catch (\Exception $e) {
            $this->errorMessage = 'Gagal memverifikasi pembayaran. Silakan coba lagi.';
        } finally {
            $this->isLoading = false;
        }

        if (! $this->order->isPaid()) {
            $this->redirect(route('payment.show', $this->order));
        }
    }

    protected function generateTicketsIfNeeded(): void
    {
        if ($this->order->tickets->isEmpty()) {
            $this->ticketService->generateTicketsForOrder($this->order);
            $this->order->load('tickets.passenger');
        }
    }

    public function refreshTickets(): void
    {
        $this->order->load('tickets.passenger');
        $this->dispatch('notify', message: 'Tiket diperbarui', type: 'success');
    }

    public function downloadPdf(): void
    {
        $token = \App\Http\Controllers\TicketPdfController::generateToken($this->order);
        $this->redirect(route('ticket.pdf.download', [
            'orderNumber' => $this->order->order_number,
            'token' => $token,
        ]));
    }

    #[Title('E-Ticket')]
    public function render()
    {
        return view('livewire.ticket-page');
    }
}
