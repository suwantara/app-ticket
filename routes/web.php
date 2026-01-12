<?php

use App\Http\Controllers\BoardingController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketPdfController;
use App\Livewire\BookingForm;
use Illuminate\Support\Facades\Route;

// Static pages with specific routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/ticket', [PageController::class, 'ticket'])->name('ticket');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Booking routes
Route::get('/booking', BookingForm::class)->name('booking.form');
Route::get('/booking/confirmation/{order}', [PageController::class, 'bookingConfirmation'])->name('booking.confirmation');

// Payment routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/{order}', [PaymentController::class, 'show'])->name('show');
    Route::post('/{order}/token', [PaymentController::class, 'createToken'])->name('token');
    Route::get('/{order}/finish', [PaymentController::class, 'finish'])->name('finish');
    Route::get('/{order}/unfinish', [PaymentController::class, 'unfinish'])->name('unfinish');
    Route::get('/{order}/error', [PaymentController::class, 'error'])->name('error');
    Route::get('/{order}/status', [PaymentController::class, 'checkStatus'])->name('status');
});

// Midtrans webhook (no CSRF)
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');

// Ticket routes
Route::prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/order/{order}', [TicketController::class, 'show'])->name('show');
    Route::get('/view/{ticket}', [TicketController::class, 'showSingle'])->name('single');
    Route::get('/download/{ticket}', [TicketController::class, 'download'])->name('download');
    Route::get('/search', [TicketController::class, 'search'])->name('search');
    Route::get('/validate-page', [TicketController::class, 'validationPage'])->name('validate.page');
    
    // PDF routes
    Route::get('/pdf/{orderNumber}/download', [TicketPdfController::class, 'download'])->name('pdf.download');
    Route::get('/pdf/{orderNumber}/view', [TicketPdfController::class, 'view'])->name('pdf.view');
    Route::get('/pdf/single/{ticketNumber}', [TicketPdfController::class, 'downloadSingle'])->name('pdf.single');
});

// Ticket API routes (for QR scanning)
Route::prefix('api/ticket')->name('api.ticket.')->group(function () {
    Route::get('/validate/{qrCode}', [TicketController::class, 'validate'])->name('validate');
    Route::post('/use/{ticket}', [TicketController::class, 'markAsUsed'])->name('use');
    Route::post('/process-validation', [TicketController::class, 'processValidation'])->name('process');
});

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

// Staff Authentication
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/login', [StaffAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StaffAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [StaffAuthController::class, 'logout'])->name('logout');
});

// Boarding System (Staff only)
Route::prefix('boarding')->name('boarding.')->middleware(\App\Http\Middleware\EnsureUserIsStaff::class)->group(function () {
    Route::get('/', [BoardingController::class, 'dashboard'])->name('dashboard');
    Route::get('/scanner', [BoardingController::class, 'scanner'])->name('scanner');
    Route::get('/list', [BoardingController::class, 'boardingList'])->name('list');
    Route::get('/stats', [BoardingController::class, 'stats'])->name('stats');
    
    // Boarding API
    Route::post('/validate', [BoardingController::class, 'validateQr'])->name('validate');
    Route::post('/board', [BoardingController::class, 'boardPassenger'])->name('board');
});

// Dynamic page route (catch-all for CMS pages)
Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('page.show');
