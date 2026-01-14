<?php

namespace App\Observers;

use App\Models\Destination;
use App\Services\CacheService;

class DestinationObserver
{
    /**
     * Handle the Destination "created" event.
     */
    public function created(Destination $destination): void
    {
        CacheService::clearDestinationCache();
    }

    /**
     * Handle the Destination "updated" event.
     */
    public function updated(Destination $destination): void
    {
        CacheService::clearDestinationCache();

        // Also clear the specific destination cache
        if ($destination->slug) {
            cache()->forget("destination:{$destination->slug}");
        }
    }

    /**
     * Handle the Destination "deleted" event.
     */
    public function deleted(Destination $destination): void
    {
        CacheService::clearDestinationCache();

        if ($destination->slug) {
            cache()->forget("destination:{$destination->slug}");
        }
    }
}
