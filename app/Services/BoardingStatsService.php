<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Schedule;
use App\Models\Ticket;
use Illuminate\Support\Collection;

/**
 * Service for boarding statistics and dashboard data
 */
class BoardingStatsService
{
    /**
     * Get today's schedules with ticket statistics
     */
    public function getTodaySchedulesWithStats(): Collection
    {
        return Schedule::with(['route.origin', 'route.destination', 'ship'])
            ->whereHas('orders', function ($q) {
                $q->where('travel_date', today())
                    ->where('payment_status', 'paid');
            })
            ->get()
            ->map(function ($schedule) {
                $orders = $schedule->orders()
                    ->where('travel_date', today())
                    ->where('payment_status', 'paid')
                    ->pluck('id');

                $totalTickets = Ticket::whereIn('order_id', $orders)->count();
                $usedTickets = Ticket::whereIn('order_id', $orders)->where('status', 'used')->count();
                $unusedTickets = Ticket::whereIn('order_id', $orders)->where('status', 'unused')->count();

                return [
                    'schedule' => $schedule,
                    'total_tickets' => $totalTickets,
                    'used_tickets' => $usedTickets,
                    'unused_tickets' => $unusedTickets,
                    'boarding_percentage' => $totalTickets > 0 ? round(($usedTickets / $totalTickets) * 100) : 0,
                ];
            });
    }

    /**
     * Get today's overall statistics
     */
    public function getTodayStats(): array
    {
        return [
            'total_orders' => Order::where('travel_date', today())->where('payment_status', 'paid')->count(),
            'total_passengers' => Ticket::whereHas('order', fn ($q) => $q->where('travel_date', today()))->count(),
            'boarded' => Ticket::whereHas('order', fn ($q) => $q->where('travel_date', today()))->where('status', 'used')->count(),
            'pending' => Ticket::whereHas('order', fn ($q) => $q->where('travel_date', today()))->where('status', 'unused')->count(),
        ];
    }

    /**
     * Get real-time stats for a specific schedule or all schedules
     */
    public function getRealtimeStats(?int $scheduleId = null): array
    {
        $query = Ticket::whereHas('order', function ($q) use ($scheduleId) {
            $q->where('travel_date', today())
                ->where('payment_status', 'paid');

            if ($scheduleId) {
                $q->where('schedule_id', $scheduleId);
            }
        });

        $total = (clone $query)->count();
        $boarded = (clone $query)->where('status', 'used')->count();
        $pending = (clone $query)->where('status', 'unused')->count();

        return [
            'total' => $total,
            'boarded' => $boarded,
            'pending' => $pending,
            'percentage' => $total > 0 ? round(($boarded / $total) * 100) : 0,
        ];
    }

    /**
     * Get human-readable status label for ticket status
     */
    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'active' => 'Aktif',
            'used' => 'Sudah Digunakan',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kadaluarsa',
            default => ucfirst($status),
        };
    }
}
