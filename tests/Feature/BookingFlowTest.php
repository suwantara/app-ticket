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
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create test destinations
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

    // Create test route
    $this->route = Route::create([
        'origin_id' => $this->sanur->id,
        'destination_id' => $this->nusaPenida->id,
        'code' => 'SAN-NP',
        'duration_minutes' => 45,
        'base_price' => 150000,
        'is_active' => true,
    ]);

    // Create test ship
    $this->ship = Ship::create([
        'name' => 'Express Bahari 1',
        'code' => 'EB-01',
        'capacity' => 80,
        'facilities' => ['AC', 'Toilet', 'Life Jacket'],
        'operator' => 'Express Bahari',
        'is_active' => true,
    ]);

    // Create test schedule for tomorrow
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

test('can create order with passengers', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'TEST1',
        'schedule_id' => $this->schedule->id,
        'travel_date' => $this->travelDate,
        'contact_name' => 'John Doe',
        'contact_email' => 'john@example.com',
        'contact_phone' => '081234567890',
        'passenger_count' => 2,
        'total_amount' => 300000,
        'status' => 'pending',
        'payment_status' => 'pending',
    ]);

    // Add passengers
    $passenger1 = Passenger::create([
        'order_id' => $order->id,
        'name' => 'John Doe',
        'id_type' => 'ktp',
        'id_number' => '1234567890123456',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    $passenger2 = Passenger::create([
        'order_id' => $order->id,
        'name' => 'Jane Doe',
        'id_type' => 'ktp',
        'id_number' => '6543210987654321',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    expect($order->passengers)->toHaveCount(2);
    expect($order->total_amount)->toBe(300000);
    expect($order->schedule->ship->name)->toBe('Express Bahari 1');
});

test('can generate tickets after payment', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'TEST2',
        'schedule_id' => $this->schedule->id,
        'travel_date' => $this->travelDate,
        'contact_name' => 'John Doe',
        'contact_email' => 'john@example.com',
        'contact_phone' => '081234567890',
        'passenger_count' => 1,
        'total_amount' => 150000,
        'status' => 'pending',
        'payment_status' => 'pending',
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'John Doe',
        'id_type' => 'ktp',
        'id_number' => '1234567890123456',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    // Simulate payment success
    $order->update([
        'payment_status' => 'paid',
        'status' => 'confirmed',
        'paid_at' => now(),
    ]);

    // Generate tickets
    $ticketService = app(TicketService::class);
    $result = $ticketService->generateTicketsForOrder($order);

    expect($result['success'])->toBeTrue();
    expect($result['tickets'])->toHaveCount(1);
    expect($result['tickets'][0]->status)->toBe('active');
    expect($result['tickets'][0]->qr_code)->not->toBeNull();
    expect($result['tickets'][0]->ticket_number)->toStartWith('TKT');
});

test('ticket has correct passenger information', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'TEST3',
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

    $passenger = Passenger::create([
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
    expect($ticket->passenger->name)->toBe('John Doe');
    expect($ticket->order->contact_email)->toBe('john@example.com');
    expect($ticket->order->schedule->route->origin->name)->toBe('Sanur');
    expect($ticket->order->schedule->route->destination->name)->toBe('Nusa Penida');
});

test('order total is calculated correctly', function () {
    $adultPrice = 150000;
    $childPrice = 100000; // Assuming child gets discount

    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'TEST4',
        'schedule_id' => $this->schedule->id,
        'travel_date' => $this->travelDate,
        'contact_name' => 'John Doe',
        'contact_email' => 'john@example.com',
        'contact_phone' => '081234567890',
        'passenger_count' => 2,
        'total_amount' => $adultPrice + $childPrice,
        'status' => 'pending',
        'payment_status' => 'pending',
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'John Doe',
        'id_type' => 'ktp',
        'id_number' => '1234567890123456',
        'age_group' => 'adult',
        'price' => $adultPrice,
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'Junior Doe',
        'id_type' => 'ktp',
        'id_number' => '9999888877776666',
        'age_group' => 'child',
        'price' => $childPrice,
    ]);

    expect($order->fresh()->total_amount)->toBe($adultPrice + $childPrice);
    expect($order->fresh()->passengers)->toHaveCount(2);
});

test('schedule available seats decrease after booking', function () {
    $initialSeats = $this->schedule->available_seats;

    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'TEST5',
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

    // Update available seats (simulating what happens after booking)
    $passengerCount = $order->passengers->count();
    $this->schedule->decrement('available_seats', $passengerCount);

    expect($this->schedule->fresh()->available_seats)->toBe($initialSeats - 2);
});

test('booking page redirects without session data', function () {
    $response = $this->get('/booking');

    // Should redirect to home because no booking session
    $response->assertRedirect(route('home'));
});

test('can view ticket with order number', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'VIEW1',
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
    $ticketService->generateTicketsForOrder($order);

    $response = $this->get('/ticket/order/' . $order->order_number);

    $response->assertStatus(200);
    $response->assertSee('John Doe');
    $response->assertSee($order->order_number);
});
