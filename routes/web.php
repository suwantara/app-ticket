<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketPdfController;
use App\Livewire\BookingForm;
use App\Livewire\TicketPage;
use Illuminate\Support\Facades\Route;

// Static pages with specific routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/ticket', [PageController::class, 'ticket'])->name('ticket');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Public Authentication Routes (with rate limiting)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,60');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Booking routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/booking', BookingForm::class)->name('booking.form');
    Route::get('/booking/confirmation/{order}', [PageController::class, 'bookingConfirmation'])->name('booking.confirmation');
});

// Payment routes (with rate limiting for sensitive operations)
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/{order}', [PaymentController::class, 'show'])->name('show');
    Route::post('/{order}/token', [PaymentController::class, 'createToken'])->name('token')->middleware('throttle:10,1');
    Route::get('/{order}/finish', [PaymentController::class, 'finish'])->name('finish');
    Route::get('/{order}/unfinish', [PaymentController::class, 'unfinish'])->name('unfinish');
    Route::get('/{order}/error', [PaymentController::class, 'error'])->name('error');
    Route::get('/{order}/status', [PaymentController::class, 'checkStatus'])->name('status')->middleware('throttle:30,1');
});

// Midtrans webhook (no CSRF)
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');

// Ticket routes
Route::prefix('ticket')->name('ticket.')->group(function () {
    // Livewire ticket page (no reload)
    Route::get('/order/{order}', TicketPage::class)->name('show');

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

// Gallery routes
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{destination}', [GalleryController::class, 'show'])->name('gallery.show');

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

// Boarding System (Staff only - standalone pages)
Route::prefix('boarding')->name('boarding.')->middleware(\App\Http\Middleware\EnsureUserIsStaff::class)->group(function () {
    Route::get('/', [BoardingController::class, 'dashboard'])->name('dashboard');
    Route::get('/scanner', [BoardingController::class, 'scanner'])->name('scanner');
    Route::get('/list', [BoardingController::class, 'boardingList'])->name('list');
});

// Boarding API (accessible from both standalone and Filament)
Route::prefix('boarding')->name('boarding.')->middleware('auth')->group(function () {
    Route::get('/stats', [BoardingController::class, 'stats'])->name('stats');
    Route::post('/validate', [BoardingController::class, 'validateQr'])->name('validate');
    Route::post('/board', [BoardingController::class, 'boardPassenger'])->name('board');
});
