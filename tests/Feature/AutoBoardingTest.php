<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Order;
use App\Models\Passenger;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Ship;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutoBoardingTest extends TestCase
{
    use RefreshDatabase;

    protected User $staff;

    protected Ticket $ticket;

    protected TicketService $ticketService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create staff user
        $this->staff = User::factory()->create([
            'role' => 'staff',
            'is_active' => true,
        ]);

        // Create necessary data for ticket
        $origin = Destination::create([
            'name' => 'Pelabuhan A',
            'slug' => 'pelabuhan-a',
            'code' => 'PA',
            'type' => 'harbor',
            'is_active' => true,
        ]);

        $destination = Destination::create([
            'name' => 'Pelabuhan B',
            'slug' => 'pelabuhan-b',
            'code' => 'PB',
            'type' => 'harbor',
            'is_active' => true,
        ]);

        $route = Route::create([
            'origin_id' => $origin->id,
            'destination_id' => $destination->id,
            'code' => 'PA-PB',
            'duration_minutes' => 60,
            'base_price' => 100000,
            'is_active' => true,
        ]);

        $ship = Ship::create([
            'name' => 'KM Test',
            'code' => 'TEST',
            'capacity' => 100,
            'is_active' => true,
        ]);

        $schedule = Schedule::create([
            'route_id' => $route->id,
            'ship_id' => $ship->id,
            'departure_time' => '08:00',
            'arrival_time' => '09:00',
            'price' => 100000,
            'available_seats' => 100,
            'days_of_week' => [0, 1, 2, 3, 4, 5, 6],
            'is_active' => true,
        ]);

        $order = Order::create([
            'order_number' => 'TKT'.date('Ymd').'AUTO1',
            'schedule_id' => $schedule->id,
            'travel_date' => today(),
            'contact_name' => 'Test User',
            'contact_email' => 'test@example.com',
            'contact_phone' => '08123456789',
            'passenger_count' => 1,
            'total_amount' => 100000,
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        $passenger = Passenger::create([
            'order_id' => $order->id,
            'name' => 'Penumpang Test',
            'id_type' => 'ktp',
            'id_number' => '1234567890123456',
            'age_group' => 'adult',
            'price' => 100000,
        ]);

        $this->ticket = Ticket::create([
            'order_id' => $order->id,
            'passenger_id' => $passenger->id,
            'status' => 'active',
            'valid_from' => today()->startOfDay(),
            'valid_until' => today()->endOfDay(),
        ]);

        $this->ticketService = app(TicketService::class);
    }

    public function test_qr_scan_auto_boards_valid_ticket(): void
    {
        $qrData = json_encode([
            'ticket_number' => $this->ticket->ticket_number,
            'qr_code' => $this->ticket->qr_code,
            'order_number' => $this->ticket->order->order_number,
        ]);

        $response = $this->actingAs($this->staff)
            ->postJson(route('boarding.validate'), [
                'qr_data' => $qrData,
                'auto_board' => true,
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'valid' => true,
                'auto_boarded' => true,
                'message' => 'Penumpang berhasil boarding!',
            ]);

        // Verify ticket status changed
        $this->ticket->refresh();
        $this->assertEquals('used', $this->ticket->status);
        $this->assertNotNull($this->ticket->used_at);
        $this->assertEquals($this->staff->name, $this->ticket->used_by);
    }

    public function test_qr_scan_does_not_auto_board_when_disabled(): void
    {
        $qrData = json_encode([
            'ticket_number' => $this->ticket->ticket_number,
            'qr_code' => $this->ticket->qr_code,
            'order_number' => $this->ticket->order->order_number,
        ]);

        $response = $this->actingAs($this->staff)
            ->postJson(route('boarding.validate'), [
                'qr_data' => $qrData,
                'auto_board' => false,
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'valid' => true,
                'auto_boarded' => false,
            ]);

        // Verify ticket status unchanged
        $this->ticket->refresh();
        $this->assertEquals('active', $this->ticket->status);
        $this->assertNull($this->ticket->used_at);
    }

    public function test_qr_scan_auto_board_default_is_enabled(): void
    {
        $qrData = json_encode([
            'ticket_number' => $this->ticket->ticket_number,
            'qr_code' => $this->ticket->qr_code,
            'order_number' => $this->ticket->order->order_number,
        ]);

        $response = $this->actingAs($this->staff)
            ->postJson(route('boarding.validate'), [
                'qr_data' => $qrData,
                // auto_board not specified, should default to true
            ]);

        $response->assertOk()
            ->assertJson([
                'auto_boarded' => true,
            ]);

        // Verify ticket was auto-boarded
        $this->ticket->refresh();
        $this->assertEquals('used', $this->ticket->status);
    }

    public function test_already_used_ticket_shows_warning(): void
    {
        // Mark ticket as used first
        $this->ticket->markAsUsed('Previous Staff');

        $qrData = json_encode([
            'ticket_number' => $this->ticket->ticket_number,
            'qr_code' => $this->ticket->qr_code,
            'order_number' => $this->ticket->order->order_number,
        ]);

        $response = $this->actingAs($this->staff)
            ->postJson(route('boarding.validate'), [
                'qr_data' => $qrData,
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'valid' => false,
                'auto_boarded' => false,
            ])
            ->assertJsonPath('ticket.status', 'used');
    }

    public function test_ticket_status_updates_in_response(): void
    {
        $qrData = json_encode([
            'qr_code' => $this->ticket->qr_code,
        ]);

        $response = $this->actingAs($this->staff)
            ->postJson(route('boarding.validate'), [
                'qr_data' => $qrData,
                'auto_board' => true,
            ]);

        $response->assertOk()
            ->assertJsonPath('ticket.status', 'used')
            ->assertJsonPath('ticket.status_label', 'Sudah Digunakan');
    }

    public function test_staff_name_recorded_as_used_by(): void
    {
        $qrData = json_encode([
            'qr_code' => $this->ticket->qr_code,
        ]);

        $this->actingAs($this->staff)
            ->postJson(route('boarding.validate'), [
                'qr_data' => $qrData,
                'auto_board' => true,
            ]);

        $this->ticket->refresh();
        $this->assertEquals($this->staff->name, $this->ticket->used_by);
    }

    public function test_invalid_qr_code_returns_error(): void
    {
        $response = $this->actingAs($this->staff)
            ->postJson(route('boarding.validate'), [
                'qr_data' => 'invalid-qr-data',
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => false,
                'valid' => false,
            ]);
    }
}
