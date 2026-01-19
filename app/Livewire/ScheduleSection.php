<?php

namespace App\Livewire;

use App\Models\Destination;
use App\Models\Schedule;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;

class ScheduleSection extends Component
{
    #[Url]
    public ?int $originId = null;

    #[Url]
    public ?int $destinationId = null;

    public string $sortBy = 'time_asc';

    public function updatedOriginId(): void
    {
        // Reset destination if same as origin
        if ($this->originId && $this->originId === $this->destinationId) {
            $this->destinationId = null;
        }
    }

    public function updatedDestinationId(): void
    {
        // Reset origin if same as destination
        if ($this->destinationId && $this->destinationId === $this->originId) {
            $this->originId = null;
        }
    }

    public function resetFilters(): void
    {
        $this->originId = null;
        $this->destinationId = null;
        $this->sortBy = 'time_asc';
    }

    public function render()
    {
        Carbon::setLocale('id');

        $today = Carbon::today();
        $dayOfWeek = $today->dayOfWeek;

        // Generate cache key based on filters and date
        $cacheKey = 'schedules_home_' . implode('_', [
            $today->format('Y-m-d'),
            $this->originId ?? 'all',
            $this->destinationId ?? 'all',
            $this->sortBy
        ]);

        $schedules = \Illuminate\Support\Facades\Cache::remember($cacheKey, 60, function () use ($today, $dayOfWeek) {
            // Base query
            $query = Schedule::with(['route.origin', 'route.destination', 'ship'])
                ->active()
                ->validOn($today)
                ->onDay($dayOfWeek);

            // Apply origin filter
            if ($this->originId) {
                $query->whereHas('route', function ($q) {
                    $q->where('origin_id', $this->originId);
                });
            }

            // Apply destination filter
            if ($this->destinationId) {
                $query->whereHas('route', function ($q) {
                    $q->where('destination_id', $this->destinationId);
                });
            }

            // Apply sorting
            match ($this->sortBy) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                default => $query->orderBy('departure_time', 'asc'),
            };

            return $query->take(6)->get();
        });

        // Get destinations for filter dropdowns (only harbors with active routes)
        $destinations = \Illuminate\Support\Facades\Cache::remember('harbor_destinations', 3600, function () {
            return Destination::active()
                ->harbors()
                ->orderBy('name')
                ->get();
        });

        // Count active filters
        $activeFilterCount = collect([
            $this->originId,
            $this->destinationId,
        ])->filter()->count();

        return view('livewire.schedule-section', [
            'schedules' => $schedules,
            'today' => $today,
            'destinations' => $destinations,
            'activeFilterCount' => $activeFilterCount,
        ]);
    }
}
