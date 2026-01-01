<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of destinations.
     */
    public function index()
    {
        $destinations = Destination::active()
            ->orderBy('order')
            ->get()
            ->groupBy('type');

        $popularDestinations = Destination::active()
            ->popular()
            ->orderBy('order')
            ->take(6)
            ->get();

        return view('destinations.index', compact('destinations', 'popularDestinations'));
    }

    /**
     * Display islands destinations.
     */
    public function islands()
    {
        $islands = Destination::active()
            ->islands()
            ->orderBy('order')
            ->get();

        return view('destinations.islands', compact('islands'));
    }

    /**
     * Display harbor destinations.
     */
    public function harbors()
    {
        $harbors = Destination::active()
            ->harbors()
            ->orderBy('order')
            ->get();

        return view('destinations.harbors', compact('harbors'));
    }

    /**
     * Display a single destination.
     */
    public function show(string $slug)
    {
        $destination = Destination::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get routes from this destination
        $routesFrom = $destination->routesFrom()
            ->where('is_active', true)
            ->with('destination')
            ->orderBy('base_price')
            ->get();

        // Get routes to this destination
        $routesTo = $destination->routesTo()
            ->where('is_active', true)
            ->with('origin')
            ->orderBy('base_price')
            ->get();

        // Related destinations (same type)
        $relatedDestinations = Destination::active()
            ->where('type', $destination->type)
            ->where('id', '!=', $destination->id)
            ->take(3)
            ->get();

        return view('destinations.show', compact('destination', 'routesFrom', 'routesTo', 'relatedDestinations'));
    }
}
