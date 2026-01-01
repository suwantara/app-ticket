<?php

namespace App\Livewire;

use App\Models\Destination;
use App\Models\Route;
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

        // Search for available routes
        $routes = Route::where('origin_id', $this->origin)
            ->where('destination_id', $this->destination)
            ->where('is_active', true)
            ->with(['origin', 'destination'])
            ->get();

        $this->searchResults = $routes->map(function ($route) {
            return [
                'id' => $route->id,
                'code' => $route->code,
                'origin' => $route->origin->name,
                'destination' => $route->destination->name,
                'duration' => $route->formatted_duration,
                'base_price' => $route->base_price,
                'total_price' => $route->base_price * $this->passengers,
            ];
        })->toArray();

        $this->showResults = true;
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
