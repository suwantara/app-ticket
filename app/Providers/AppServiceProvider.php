<?php

namespace App\Providers;

use App\Models\Destination;
use App\Models\Schedule;
use App\Observers\DestinationObserver;
use App\Observers\ScheduleObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Carbon locale to Indonesian
        \Carbon\Carbon::setLocale(config('app.locale', 'id'));

        // Register model observers for cache invalidation
        Destination::observe(DestinationObserver::class);
        Schedule::observe(ScheduleObserver::class);
    }
}
