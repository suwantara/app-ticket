<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Search available schedules
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'origin_id' => 'required|exists:destinations,id',
            'destination_id' => 'required|exists:destinations,id|different:origin_id',
            'date' => 'required|date|after_or_equal:today',
            'passengers' => 'nullable|integer|min:1|max:50',
        ]);

        $date = Carbon::parse($validated['date']);
        $passengers = $validated['passengers'] ?? 1;
        $dayOfWeek = $date->dayOfWeek;

        // Find routes for this origin-destination pair
        $routes = Route::where('origin_id', $validated['origin_id'])
            ->where('destination_id', $validated['destination_id'])
            ->active()
            ->pluck('id');

        if ($routes->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Tidak ada rute yang tersedia untuk tujuan ini.',
            ]);
        }

        // Find schedules for these routes
        $schedules = Schedule::whereIn('route_id', $routes)
            ->active()
            ->validOn($date)
            ->onDay($dayOfWeek)
            ->where('available_seats', '>=', $passengers)
            ->with(['route.origin', 'route.destination', 'ship'])
            ->orderBy('departure_time')
            ->get();

        $results = $schedules->map(function ($schedule) use ($passengers) {
            return [
                'id' => $schedule->id,
                'route' => [
                    'id' => $schedule->route->id,
                    'code' => $schedule->route->code,
                    'origin' => $schedule->route->origin->name,
                    'destination' => $schedule->route->destination->name,
                ],
                'ship' => [
                    'id' => $schedule->ship->id,
                    'name' => $schedule->ship->name,
                    'code' => $schedule->ship->code,
                    'operator' => $schedule->ship->operator,
                    'facilities' => $schedule->ship->facilities ?? [],
                ],
                'departure_time' => $schedule->departure_time_formatted,
                'arrival_time' => $schedule->arrival_time_formatted,
                'duration' => $schedule->route->formatted_duration,
                'price' => $schedule->price,
                'price_formatted' => 'Rp ' . number_format($schedule->price, 0, ',', '.'),
                'total_price' => $schedule->price * $passengers,
                'total_price_formatted' => 'Rp ' . number_format($schedule->price * $passengers, 0, ',', '.'),
                'available_seats' => $schedule->available_seats,
                'passengers' => $passengers,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $results,
            'meta' => [
                'origin_id' => (int) $validated['origin_id'],
                'destination_id' => (int) $validated['destination_id'],
                'date' => $date->format('Y-m-d'),
                'day' => $date->translatedFormat('l'),
                'passengers' => (int) $passengers,
                'total_schedules' => $results->count(),
            ],
        ]);
    }

    /**
     * Get schedule details by ID
     *
     * @param Schedule $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Schedule $schedule)
    {
        $schedule->load(['route.origin', 'route.destination', 'ship']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $schedule->id,
                'route' => [
                    'id' => $schedule->route->id,
                    'code' => $schedule->route->code,
                    'origin' => $schedule->route->origin->name,
                    'destination' => $schedule->route->destination->name,
                    'duration' => $schedule->route->formatted_duration,
                ],
                'ship' => [
                    'id' => $schedule->ship->id,
                    'name' => $schedule->ship->name,
                    'code' => $schedule->ship->code,
                    'operator' => $schedule->ship->operator,
                    'capacity' => $schedule->ship->capacity,
                    'facilities' => $schedule->ship->facilities ?? [],
                ],
                'departure_time' => $schedule->departure_time_formatted,
                'arrival_time' => $schedule->arrival_time_formatted,
                'price' => $schedule->price,
                'price_formatted' => 'Rp ' . number_format($schedule->price, 0, ',', '.'),
                'available_seats' => $schedule->available_seats,
                'days_of_week' => $schedule->days_of_week,
                'days_label' => $schedule->days_label,
                'valid_from' => $schedule->valid_from?->format('Y-m-d'),
                'valid_until' => $schedule->valid_until?->format('Y-m-d'),
                'notes' => $schedule->notes,
            ],
        ]);
    }
}
