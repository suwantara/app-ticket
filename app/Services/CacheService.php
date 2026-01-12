<?php

namespace App\Services;

use App\Models\Destination;
// Page model removed from architecture (static pages used)
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Ship;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache TTL in seconds
     */
    const TTL_SHORT = 300;      // 5 minutes

    const TTL_MEDIUM = 1800;    // 30 minutes

    const TTL_LONG = 3600;      // 1 hour

    const TTL_DAY = 86400;      // 24 hours

    /**
     * Cache keys
     */
    const KEY_DESTINATIONS = 'destinations';

    const KEY_ACTIVE_DESTINATIONS = 'active_destinations';

    const KEY_ISLANDS = 'islands';

    const KEY_HARBORS = 'harbors';

    const KEY_ROUTES = 'routes';

    const KEY_ACTIVE_ROUTES = 'active_routes';

    const KEY_SHIPS = 'ships';

    const KEY_ACTIVE_SHIPS = 'active_ships';

    const KEY_SCHEDULES = 'schedules';
    // Page-related cache keys removed

    /**
     * Get all active destinations (cached)
     */
    public static function getActiveDestinations()
    {
        return Cache::remember(self::KEY_ACTIVE_DESTINATIONS, self::TTL_MEDIUM, function () {
            return Destination::where('is_active', true)
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get all destinations (cached)
     */
    public static function getDestinations()
    {
        return Cache::remember(self::KEY_DESTINATIONS, self::TTL_MEDIUM, function () {
            return Destination::orderBy('name')->get();
        });
    }

    /**
     * Get islands (cached)
     */
    public static function getIslands()
    {
        return Cache::remember(self::KEY_ISLANDS, self::TTL_MEDIUM, function () {
            return Destination::where('is_active', true)
                ->where('type', 'island')
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get harbors (cached)
     */
    public static function getHarbors()
    {
        return Cache::remember(self::KEY_HARBORS, self::TTL_MEDIUM, function () {
            return Destination::where('is_active', true)
                ->where('type', 'harbor')
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get all active routes (cached)
     */
    public static function getActiveRoutes()
    {
        return Cache::remember(self::KEY_ACTIVE_ROUTES, self::TTL_MEDIUM, function () {
            return Route::with(['origin', 'destination'])
                ->where('is_active', true)
                ->orderBy('origin_id')
                ->get();
        });
    }

    /**
     * Get all active ships (cached)
     */
    public static function getActiveShips()
    {
        return Cache::remember(self::KEY_ACTIVE_SHIPS, self::TTL_MEDIUM, function () {
            return Ship::where('is_active', true)
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get schedules for a specific date and route (cached)
     */
    public static function getSchedules(int $routeId, string $date)
    {
        $key = "schedules:{$routeId}:{$date}";

        return Cache::remember($key, self::TTL_SHORT, function () use ($routeId, $date) {
            return Schedule::with(['route.origin', 'route.destination', 'ship'])
                ->where('route_id', $routeId)
                ->where('departure_date', $date)
                ->where('is_active', true)
                ->where('available_seats', '>', 0)
                ->orderBy('departure_time')
                ->get();
        });
    }

    // Navbar/pages caching removed; static menus used instead

    /**
     * Get single destination by slug (cached)
     */
    public static function getDestinationBySlug(string $slug)
    {
        return Cache::remember("destination:{$slug}", self::TTL_MEDIUM, function () use ($slug) {
            return Destination::where('slug', $slug)
                ->where('is_active', true)
                ->first();
        });
    }

    // Page lookups removed

    /**
     * Clear all destination-related cache
     */
    public static function clearDestinationCache()
    {
        Cache::forget(self::KEY_DESTINATIONS);
        Cache::forget(self::KEY_ACTIVE_DESTINATIONS);
        Cache::forget(self::KEY_ISLANDS);
        Cache::forget(self::KEY_HARBORS);
    }

    /**
     * Clear all route-related cache
     */
    public static function clearRouteCache()
    {
        Cache::forget(self::KEY_ROUTES);
        Cache::forget(self::KEY_ACTIVE_ROUTES);
    }

    /**
     * Clear all ship-related cache
     */
    public static function clearShipCache()
    {
        Cache::forget(self::KEY_SHIPS);
        Cache::forget(self::KEY_ACTIVE_SHIPS);
    }

    /**
     * Clear schedule cache for specific route/date
     */
    public static function clearScheduleCache(?int $routeId = null, ?string $date = null)
    {
        if ($routeId && $date) {
            Cache::forget("schedules:{$routeId}:{$date}");
        } elseif ($routeId) {
            // Clear all dates for this route (pattern matching would be better with Redis)
            Cache::forget(self::KEY_SCHEDULES);
        } else {
            Cache::forget(self::KEY_SCHEDULES);
        }
    }

    /**
     * Clear all page-related cache
     */
    public static function clearPageCache()
    {
        // no-op: page cache removed
    }

    /**
     * Clear all application cache
     */
    public static function clearAll()
    {
        self::clearDestinationCache();
        self::clearRouteCache();
        self::clearShipCache();
        self::clearScheduleCache();
        // pages removed
    }
}
