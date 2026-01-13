<?php

namespace App\Livewire;

use App\Models\Schedule;
use Carbon\Carbon;
use Livewire\Component;

class ScheduleSection extends Component
{
    public function render()
    {
        // Ensure Carbon uses Indonesian locale
        Carbon::setLocale('id');

        $today = Carbon::today();
        $dayOfWeek = $today->dayOfWeek;

        // Get today's popular schedules with route info
        $schedules = Schedule::with(['route.origin', 'route.destination', 'ship'])
            ->active()
            ->validOn($today)
            ->onDay($dayOfWeek)
            ->orderBy('departure_time')
            ->take(6)
            ->get();

        return view('livewire.schedule-section', [
            'schedules' => $schedules,
            'today' => $today,
        ]);
    }
}
