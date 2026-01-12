<?php

namespace App\Observers;

use App\Models\Schedule;
use App\Services\CacheService;

class ScheduleObserver
{
    /**
     * Handle the Schedule "created" event.
     */
    public function created(Schedule $schedule): void
    {
        $this->clearScheduleCache($schedule);
    }

    /**
     * Handle the Schedule "updated" event.
     */
    public function updated(Schedule $schedule): void
    {
        $this->clearScheduleCache($schedule);
    }

    /**
     * Handle the Schedule "deleted" event.
     */
    public function deleted(Schedule $schedule): void
    {
        $this->clearScheduleCache($schedule);
    }

    /**
     * Clear schedule cache for the affected route and date
     */
    protected function clearScheduleCache(Schedule $schedule): void
    {
        if ($schedule->route_id && $schedule->departure_date) {
            CacheService::clearScheduleCache(
                $schedule->route_id,
                $schedule->departure_date->format('Y-m-d')
            );
        }
    }
}
