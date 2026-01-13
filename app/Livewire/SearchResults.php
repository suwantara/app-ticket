<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class SearchResults extends Component
{
    public array $searchResults = [];
    public array $returnResults = [];
    public bool $showResults = false;
    public bool $returnTrip = false;
    public int $passengers = 1;
    public string $date = '';
    public string $returnDate = '';

    // Selected schedules
    public ?int $selectedScheduleId = null;
    public ?int $selectedReturnScheduleId = null;

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
