<?php

namespace App\Livewire;

use App\Models\Destination;
use App\Models\Route;
use App\Models\Schedule;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class SearchBookingForm extends Component
{
    public $origin = '';
    public $destination = '';
    public $date = '';
    public $passengers = 1;
    public $returnTrip = false;
    public $returnDate = '';
    public $availableDestinations = [];

    // Track if search has been performed
    public $hasSearched = false;

    public function mount()
    {
        $this->date = now()->addDay()->format('Y-m-d');
        $this->returnDate = now()->addDays(3)->format('Y-m-d');

        // Load destinations for dropdowns
        $this->availableDestinations = Destination::active()
            ->orderBy('type')
            ->orderBy('name')
            ->get()
            ->groupBy('type')
            ->toArray();

        // Pre-fill from query parameters (from schedule section)
        if (request()->has('origin')) {
            $this->origin = request()->query('origin');
        }
        if (request()->has('destination')) {
            $this->destination = request()->query('destination');
        }
    }

    public function updatedOrigin()
    {
        // Reset destination if same as origin
        if ($this->origin === $this->destination) {
            $this->destination = '';
        }
    }

    public function updatedPassengers()
    {
        // Ensure passengers is within bounds
        $this->passengers = max(1, min(20, (int) $this->passengers));

        // If search has been performed, re-search with new passenger count
        if ($this->hasSearched && $this->origin && $this->destination && $this->date) {
            $this->search();
        }
    }

    public function updatedReturnTrip()
    {
        // If search has been performed, re-search when toggling return trip
        if ($this->hasSearched && $this->origin && $this->destination && $this->date) {
            $this->search();
        }
    }

    public function updatedDate()
    {
        // If search has been performed, re-search when date changes
        if ($this->hasSearched && $this->origin && $this->destination) {
            $this->search();
        }
    }

    public function updatedReturnDate()
    {
        // If search has been performed and return trip, re-search
        if ($this->hasSearched && $this->returnTrip && $this->origin && $this->destination && $this->date) {
            $this->search();
        }
    }

    #[On('fill-route')]
    public function fillRoute(int $originId, int $destinationId): void
    {
        $this->origin = (string) $originId;
        $this->destination = (string) $destinationId;
    }

    public function search()
    {
        $this->validate([
            'origin' => 'required',
            'destination' => 'required|different:origin',
            'date' => 'required|date|after_or_equal:today',
            'passengers' => 'required|integer|min:1|max:20',
            'returnDate' => $this->returnTrip ? 'required|date|after:date' : '',
        ], [
            'origin.required' => 'Pilih lokasi keberangkatan',
            'destination.required' => 'Pilih lokasi tujuan',
            'destination.different' => 'Tujuan harus berbeda dengan keberangkatan',
            'date.after_or_equal' => 'Tanggal tidak boleh di masa lalu',
            'returnDate.after' => 'Tanggal pulang harus setelah tanggal berangkat',
            'passengers.min' => 'Minimal 1 penumpang',
            'passengers.max' => 'Maksimal 20 penumpang',
        ]);

        $this->hasSearched = true;

        // Dispatch event to show loading skeleton
        $this->dispatch('search-started');

        // Search outbound schedules
        $searchResults = $this->findSchedules(
            $this->origin,
            $this->destination,
            $this->date
        );

        // Search return schedules if round trip
        $returnResults = [];
        if ($this->returnTrip && $this->returnDate) {
            $returnResults = $this->findSchedules(
                $this->destination,
                $this->origin,
                $this->returnDate
            );
        }

        // Dispatch event to SearchResults component
        $this->dispatch('search-completed', [
            'searchResults' => $searchResults,
            'returnResults' => $returnResults,
            'returnTrip' => $this->returnTrip,
            'passengers' => $this->passengers,
            'date' => $this->date,
            'returnDate' => $this->returnDate,
        ]);
    }

    protected function findSchedules($originId, $destinationId, $date)
    {
        $date = Carbon::parse($date);
        $dayOfWeek = $date->dayOfWeek;

        // Find routes for this origin-destination pair
        $routes = Route::where('origin_id', $originId)
            ->where('destination_id', $destinationId)
            ->active()
            ->pluck('id');

        if ($routes->isEmpty()) {
            return [];
        }

        // Find schedules for these routes
        $schedules = Schedule::whereIn('route_id', $routes)
            ->active()
            ->validOn($date)
            ->onDay($dayOfWeek)
            ->where('available_seats', '>=', $this->passengers)
            ->with(['route.origin', 'route.destination', 'ship'])
            ->orderBy('departure_time')
            ->get();

        return $schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'route_code' => $schedule->route->code,
                'origin' => $schedule->route->origin->name,
                'destination' => $schedule->route->destination->name,
                'ship_name' => $schedule->ship->name,
                'ship_code' => $schedule->ship->code,
                'operator' => $schedule->ship->operator,
                'facilities' => $schedule->ship->facilities ?? [],
                'departure_time' => $schedule->departure_time_formatted,
                'arrival_time' => $schedule->arrival_time_formatted,
                'duration' => $schedule->route->formatted_duration,
                'price' => $schedule->price,
                'price_formatted' => 'Rp '.number_format($schedule->price, 0, ',', '.'),
                'total_price' => $schedule->price * $this->passengers,
                'total_price_formatted' => 'Rp '.number_format($schedule->price * $this->passengers, 0, ',', '.'),
                'available_seats' => $schedule->available_seats,
            ];
        })->toArray();
    }

    public function render()
    {
        // Cache destinations query to avoid repeated DB calls on re-render
        $destinations = cache()->remember('active_destinations', 300, function () {
            return Destination::active()
                ->orderBy('type')
                ->orderBy('order')
                ->get();
        });

        return view('livewire.search-booking-form', [
            'destinations' => $destinations,
        ]);
    }
}
