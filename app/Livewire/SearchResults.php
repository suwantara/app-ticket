<?php

namespace App\Livewire;

use App\Models\Route;
use Livewire\Attributes\On;
use Livewire\Component;

class SearchResults extends Component
{
    public array $searchResults = [];
    public array $returnResults = [];
    public bool $showResults = false;
    public bool $returnTrip = false;
    public bool $isSearching = false;
    public int $passengers = 1;
    public string $date = '';
    public string $returnDate = '';

    // Selected schedules
    public ?int $selectedScheduleId = null;
    public ?int $selectedReturnScheduleId = null;

    // Popular routes for quick suggestions
    public array $popularRoutes = [];

    public function mount(): void
    {
        // Load popular routes for suggestions
        $this->popularRoutes = Route::with(['origin', 'destination'])
            ->active()
            ->take(4)
            ->get()
            ->map(fn($route) => [
                'id' => $route->id,
                'origin_id' => $route->origin_id,
                'destination_id' => $route->destination_id,
                'origin_name' => $route->origin->name ?? 'Origin',
                'destination_name' => $route->destination->name ?? 'Destination',
                'duration' => $route->formatted_duration,
            ])
            ->toArray();
    }

    #[On('search-started')]
    public function handleSearchStarted(): void
    {
        $this->isSearching = true;
    }

    #[On('search-completed')]
    public function handleSearchResults(array $data): void
    {
        $this->searchResults = $data['searchResults'] ?? [];
        $this->returnResults = $data['returnResults'] ?? [];
        $this->returnTrip = $data['returnTrip'] ?? false;
        $this->passengers = $data['passengers'] ?? 1;
        $this->date = $data['date'] ?? '';
        $this->returnDate = $data['returnDate'] ?? '';
        $this->showResults = true;
        $this->isSearching = false;

        // Reset selections
        $this->selectedScheduleId = null;
        $this->selectedReturnScheduleId = null;
    }

    public function selectSchedule(int $scheduleId, bool $isReturn = false): void
    {
        if ($isReturn) {
            $this->selectedReturnScheduleId = $scheduleId;
        } else {
            $this->selectedScheduleId = $scheduleId;
        }
    }

    public function selectPopularRoute(int $originId, int $destinationId): void
    {
        $this->dispatch('fill-route', originId: $originId, destinationId: $destinationId);
    }

    public function getSelectedTotalProperty(): int
    {
        $total = 0;

        if ($this->selectedScheduleId) {
            foreach ($this->searchResults as $schedule) {
                if ($schedule['id'] == $this->selectedScheduleId) {
                    $total += $schedule['total_price'];
                    break;
                }
            }
        }

        if ($this->selectedReturnScheduleId) {
            foreach ($this->returnResults as $schedule) {
                if ($schedule['id'] == $this->selectedReturnScheduleId) {
                    $total += $schedule['total_price'];
                    break;
                }
            }
        }

        return $total;
    }

    public function proceedToBooking()
    {
        // Validate user is authenticated
        if (!auth()->check()) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk melanjutkan pemesanan.');
            return redirect()->route('login', ['redirect' => route('ticket')]);
        }

        if (!$this->selectedScheduleId) {
            session()->flash('error', 'Pilih jadwal keberangkatan terlebih dahulu.');
            return null;
        }

        if ($this->returnTrip && !$this->selectedReturnScheduleId) {
            session()->flash('error', 'Pilih jadwal kepulangan terlebih dahulu.');
            return null;
        }

        // Store booking data in session
        session([
            'booking' => [
                'schedule_id' => $this->selectedScheduleId,
                'return_schedule_id' => $this->selectedReturnScheduleId,
                'travel_date' => $this->date,
                'return_date' => $this->returnDate,
                'passengers' => $this->passengers,
                'is_round_trip' => $this->returnTrip,
            ],
        ]);

        return redirect()->route('booking.form');
    }

    public function render()
    {
        return view('livewire.search-results', [
            'selectedTotal' => $this->selectedTotal,
        ]);
    }
}
