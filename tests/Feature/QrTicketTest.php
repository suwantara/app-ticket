<?php

use App\Models\Destination;
use App\Models\Order;
use App\Models\Passenger;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Ship;
use App\Models\Ticket;
use App\Services\TicketService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create test data
    $this->sanur = Destination::create([
        'name' => 'Sanur',
        'slug' => 'sanur',
        'type' => 'harbor',
        'is_active' => true,
    ]);

    $this->nusaPenida = Destination::create([
        'name' => 'Nusa Penida',
        'slug' => 'nusa-penida',
        'type' => 'island',
        'is_active' => true,
    ]);

    $this->route = Route::create([
        'origin_id' => $this->sanur->id,
        'destination_id' => $this->nusaPenida->id,
        'code' => 'SAN-NP',
        'duration_minutes' => 45,
        'base_price' => 150000,
        'is_active' => true,
    ]);

    $this->ship = Ship::create([
        'name' => 'Express Bahari 1',
        'code' => 'EB-01',
        'capacity' => 80,
        'facilities' => ['AC', 'Toilet', 'Life Jacket'],
        'operator' => 'Express Bahari',
        'is_active' => true,
    ]);

    $this->schedule = Schedule::create([
        'route_id' => $this->route->id,
        'ship_id' => $this->ship->id,
        'departure_time' => '08:00',
        'arrival_time' => '08:45',
        'price' => 150000,
        'available_seats' => 80,
        'days_of_week' => [0, 1, 2, 3, 4, 5, 6],
        'is_active' => true,
    ]);

    $this->travelDate = Carbon::tomorrow()->format('Y-m-d');
});

test('ticket QR code contains correct data', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'QR001',
        'schedule_id' => $this->schedule->id,
        'travel_date' => $this->travelDate,
        'contact_name' => 'John Doe',
        'contact_email' => 'john@example.com',
        'contact_phone' => '081234567890',
        'passenger_count' => 1,
        'total_amount' => 150000,
        'status' => 'confirmed',
        'payment_status' => 'paid',
        'paid_at' => now(),
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'John Doe',
        'id_type' => 'ktp',
        'id_number' => '1234567890123456',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    $ticketService = app(TicketService::class);
    $result = $ticketService->generateTicketsForOrder($order);
    $ticket = $result['tickets'][0];

    // QR code and ticket_number should both exist
    expect($ticket->qr_code)->not->toBeNull();
    expect($ticket->ticket_number)->toStartWith('TKT');
});

test('ticket can be verified by QR data', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'QR002',
        'schedule_id' => $this->schedule->id,
        'travel_date' => Carbon::today()->format('Y-m-d'), // Today for valid validation
        'contact_name' => 'John Doe',
        'contact_email' => 'john@example.com',
        'contact_phone' => '081234567890',
        'passenger_count' => 1,
        'total_amount' => 150000,
        'status' => 'confirmed',
        'payment_status' => 'paid',
        'paid_at' => now(),
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'John Doe',
        'id_type' => 'ktp',
        'id_number' => '1234567890123456',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    $ticketService = app(TicketService::class);
    $result = $ticketService->generateTicketsForOrder($order);
    $ticket = $result['tickets'][0];

    // Verify ticket using QR code
    $verifyResult = $ticketService->validateTicket($ticket->qr_code);

    expect($verifyResult['valid'])->toBeTrue();
    expect($verifyResult['ticket']->id)->toBe($ticket->id);
});

test('invalid QR code returns error', function () {
    $ticketService = app(TicketService::class);
    $result = $ticketService->validateTicket('INVALID_QR_CODE_DATA');

    expect($result['valid'])->toBeFalse();
});

test('ticket can be checked in (boarded)', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'QR003',
        'schedule_id' => $this->schedule->id,
        'travel_date' => Carbon::today()->format('Y-m-d'), // Today for boarding
        'contact_name' => 'John Doe',
        'contact_email' => 'john@example.com',
        'contact_phone' => '081234567890',
        'passenger_count' => 1,
        'total_amount' => 150000,
        'status' => 'confirmed',
        'payment_status' => 'paid',
        'paid_at' => now(),
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'John Doe',
        'id_type' => 'ktp',
        'id_number' => '1234567890123456',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    $ticketService = app(TicketService::class);
    $result = $ticketService->generateTicketsForOrder($order);
    $ticket = $result['tickets'][0];

    // Check in ticket using useTicket method
    $useResult = $ticketService->useTicket($ticket);

    expect($useResult['success'])->toBeTrue();
    expect($ticket->fresh()->status)->toBe('used');
    expect($ticket->fresh()->used_at)->not->toBeNull();
});

test('used ticket cannot be checked in again', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'QR004',
        'schedule_id' => $this->schedule->id,
        'travel_date' => Carbon::today()->format('Y-m-d'),
        'contact_name' => 'John Doe',
        'contact_email' => 'john@example.com',
        'contact_phone' => '081234567890',
        'passenger_count' => 1,
        'total_amount' => 150000,
        'status' => 'confirmed',
        'payment_status' => 'paid',
        'paid_at' => now(),
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'John Doe',
        'id_type' => 'ktp',
        'id_number' => '1234567890123456',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    $ticketService = app(TicketService::class);
    $result = $ticketService->generateTicketsForOrder($order);
    $ticket = $result['tickets'][0];

    // First check-in should succeed
    $ticketService->useTicket($ticket);

    // Refresh ticket from database
    $ticket = $ticket->fresh();

    // Second check-in should fail
    $useResult = $ticketService->useTicket($ticket);

    expect($useResult['success'])->toBeFalse();
});

test('ticket for wrong date cannot be used', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'QR005',
        'schedule_id' => $this->schedule->id,
        'travel_date' => Carbon::tomorrow()->format('Y-m-d'), // Tomorrow, not today
        'contact_name' => 'John Doe',
        'contact_email' => 'john@example.com',
        'contact_phone' => '081234567890',
        'passenger_count' => 1,
        'total_amount' => 150000,
        'status' => 'confirmed',
        'payment_status' => 'paid',
        'paid_at' => now(),
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'John Doe',
        'id_type' => 'ktp',
        'id_number' => '1234567890123456',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    $ticketService = app(TicketService::class);
    $result = $ticketService->generateTicketsForOrder($order);
    $ticket = $result['tickets'][0];

    // Should fail because travel date is tomorrow
    $useResult = $ticketService->useTicket($ticket);

    expect($useResult['success'])->toBeFalse();
});

test('QR scanner page redirects to login for unauthenticated users', function () {
    $response = $this->get('/boarding/scanner');

    // Should redirect to staff login if not authenticated
    $response->assertRedirect(route('staff.login'));
});

test('ticket list shows all tickets for order', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'QR006',
        'schedule_id' => $this->schedule->id,
        'travel_date' => $this->travelDate,
        'contact_name' => 'John Doe',
        'contact_email' => 'john@example.com',
        'contact_phone' => '081234567890',
        'passenger_count' => 2,
        'total_amount' => 300000,
        'status' => 'confirmed',
        'payment_status' => 'paid',
        'paid_at' => now(),
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'John Doe',
        'id_type' => 'ktp',
        'id_number' => '1234567890123456',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'Jane Doe',
        'id_type' => 'ktp',
        'id_number' => '6543210987654321',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    $ticketService = app(TicketService::class);
    $result = $ticketService->generateTicketsForOrder($order);

    expect($result['success'])->toBeTrue();
    expect($result['tickets'])->toHaveCount(2);
    
    $ticketNames = collect($result['tickets'])->pluck('passenger.name')->toArray();
    expect($ticketNames)->toContain('John Doe');
    expect($ticketNames)->toContain('Jane Doe');
});
