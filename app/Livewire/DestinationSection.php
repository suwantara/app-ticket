<?php

namespace App\Livewire;

use App\Models\Destination;
use Livewire\Component;

class DestinationSection extends Component
{
    public ?Destination $selectedDestination = null;
    public bool $showModal = false;

    public function showDetail(int $destinationId): void
    {
        $this->selectedDestination = Destination::find($destinationId);
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedDestination = null;
    }

    public function render()
    {
        $destinations = \Illuminate\Support\Facades\Cache::remember('popular_destinations', 3600, function () {
            return Destination::active()->popular()->orderBy('order')->take(4)->get();
        });

        return view('livewire.destination-section', [
            'destinations' => $destinations,
        ]);
    }
}
