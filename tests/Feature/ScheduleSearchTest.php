<?php

use App\Models\Destination;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Ship;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
});

test('can search schedules for valid date', function () {
    Schedule::create([
        'route_id' => $this->route->id,
        'ship_id' => $this->ship->id,
        'departure_time' => '08:00',
        'arrival_time' => '08:45',
        'price' => 150000,
        'available_seats' => 80,
        'days_of_week' => [0, 1, 2, 3, 4, 5, 6],
        'is_active' => true,
    ]);

    $tomorrow = Carbon::tomorrow()->format('Y-m-d');

    $response = $this->getJson("/schedules/search?origin_id={$this->sanur->id}&destination_id={$this->nusaPenida->id}&date={$tomorrow}&passengers=2");

    $response->assertStatus(200)
        ->assertJson(['success' => true])
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.ship.name', 'Express Bahari 1')
        ->assertJsonPath('data.0.departure_time', '08:00')
        ->assertJsonPath('meta.passengers', 2);
});

test('returns empty when no schedules match day of week', function () {
    Schedule::create([
        'route_id' => $this->route->id,
        'ship_id' => $this->ship->id,
        'departure_time' => '08:00',
        'arrival_time' => '08:45',
        'price' => 150000,
        'available_seats' => 80,
        'days_of_week' => [1], // Monday only
        'is_active' => true,
    ]);

    // Find next Sunday (day 0)
    $sunday = Carbon::now()->next(Carbon::SUNDAY)->format('Y-m-d');

    $response = $this->getJson("/schedules/search?origin_id={$this->sanur->id}&destination_id={$this->nusaPenida->id}&date={$sunday}&passengers=1");

    $response->assertStatus(200)
        ->assertJson(['success' => true])
        ->assertJsonCount(0, 'data');
});

test('filters by available seats', function () {
    Schedule::create([
        'route_id' => $this->route->id,
        'ship_id' => $this->ship->id,
        'departure_time' => '08:00',
        'arrival_time' => '08:45',
        'price' => 150000,
        'available_seats' => 5,
        'days_of_week' => [0, 1, 2, 3, 4, 5, 6],
        'is_active' => true,
    ]);

    $tomorrow = Carbon::tomorrow()->format('Y-m-d');

    // Request for 10 passengers - should return empty
    $this->getJson("/schedules/search?origin_id={$this->sanur->id}&destination_id={$this->nusaPenida->id}&date={$tomorrow}&passengers=10")
        ->assertStatus(200)
        ->assertJsonCount(0, 'data');

    // Request for 5 passengers - should return result
    $this->getJson("/schedules/search?origin_id={$this->sanur->id}&destination_id={$this->nusaPenida->id}&date={$tomorrow}&passengers=5")
        ->assertStatus(200)
        ->assertJsonCount(1, 'data');
});

test('validates required parameters', function () {
    $this->getJson('/schedules/search')
        ->assertStatus(422)
        ->assertJsonValidationErrors(['origin_id', 'destination_id', 'date']);
});

test('validates different origin and destination', function () {
    $tomorrow = Carbon::tomorrow()->format('Y-m-d');

    $this->getJson("/schedules/search?origin_id={$this->sanur->id}&destination_id={$this->sanur->id}&date={$tomorrow}")
        ->assertStatus(422)
        ->assertJsonValidationErrors(['destination_id']);
});

test('can get schedule details', function () {
    $schedule = Schedule::create([
        'route_id' => $this->route->id,
        'ship_id' => $this->ship->id,
        'departure_time' => '08:00',
        'arrival_time' => '08:45',
        'price' => 150000,
        'available_seats' => 80,
        'days_of_week' => [0, 1, 2, 3, 4, 5, 6],
        'is_active' => true,
    ]);

    $this->getJson("/schedules/{$schedule->id}")
        ->assertStatus(200)
        ->assertJson(['success' => true])
        ->assertJsonPath('data.id', $schedule->id)
        ->assertJsonPath('data.ship.name', 'Express Bahari 1')
        ->assertJsonPath('data.route.code', 'SAN-NP');
});
