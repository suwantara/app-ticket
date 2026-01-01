<?php

namespace App\Livewire;

use App\Models\Destination;
use App\Models\Route;
use App\Models\Schedule;
use Carbon\Carbon;
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
    public $searchResults = [];
    public $returnResults = [];
    public $showResults = false;

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
    }

    public function updatedOrigin()
    {
        // Reset destination if same as origin
        if ($this->origin === $this->destination) {
            $this->destination = '';
        }
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
        ]);

        // Search outbound schedules
        $this->searchResults = $this->findSchedules(
            $this->origin,
            $this->destination,
            $this->date
        );

        // Search return schedules if round trip
        $this->returnResults = [];
        if ($this->returnTrip && $this->returnDate) {
            $this->returnResults = $this->findSchedules(
                $this->destination,
                $this->origin,
                $this->returnDate
            );
        }

        $this->showResults = true;
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
                'price_formatted' => 'Rp ' . number_format($schedule->price, 0, ',', '.'),
                'total_price' => $schedule->price * $this->passengers,
                'total_price_formatted' => 'Rp ' . number_format($schedule->price * $this->passengers, 0, ',', '.'),
                'available_seats' => $schedule->available_seats,
            ];
        })->toArray();
    }

    public function render()
    {
        $destinations = Destination::active()
            ->orderBy('type')
            ->orderBy('order')
            ->get();

        return view('livewire.search-booking-form', [
            'destinations' => $destinations,
        ]);
    }
}
