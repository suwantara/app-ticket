<?php

use App\Console\Commands\ExpireUnpaidOrders;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule order expiration check every 5 minutes
Schedule::command(ExpireUnpaidOrders::class)->everyFiveMinutes();
