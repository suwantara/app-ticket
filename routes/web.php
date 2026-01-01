<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

// Static pages with specific routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Destination routes
Route::prefix('destinations')->name('destinations.')->group(function () {
    Route::get('/', [DestinationController::class, 'index'])->name('index');
    Route::get('/islands', [DestinationController::class, 'islands'])->name('islands');
    Route::get('/harbors', [DestinationController::class, 'harbors'])->name('harbors');
    Route::get('/{slug}', [DestinationController::class, 'show'])->name('show');
});

// Schedule search routes (API-style for AJAX)
Route::prefix('schedules')->name('schedules.')->group(function () {
    Route::get('/search', [ScheduleController::class, 'search'])->name('search');
    Route::get('/{schedule}', [ScheduleController::class, 'show'])->name('show');
});

// Dynamic page route (catch-all for CMS pages)
Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('page.show');
