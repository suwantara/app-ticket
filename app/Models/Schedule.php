<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $fillable = [
        'route_id',
        'ship_id',
        'departure_time',
        'arrival_time',
        'price',
        'available_seats',
        'days_of_week',
        'valid_from',
        'valid_until',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'departure_time' => 'datetime:H:i',
        'arrival_time' => 'datetime:H:i',
        'days_of_week' => 'array',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'price' => 'integer',
        'available_seats' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValidOn($query, $date)
    {
        return $query->where(function ($q) use ($date) {
            $q->whereNull('valid_from')
                ->orWhere('valid_from', '<=', $date);
        })->where(function ($q) use ($date) {
            $q->whereNull('valid_until')
                ->orWhere('valid_until', '>=', $date);
        });
    }

    public function scopeOnDay($query, $dayOfWeek)
    {
        return $query->whereJsonContains('days_of_week', $dayOfWeek);
    }

    public function scopeForRoute($query, $routeId)
    {
        return $query->where('route_id', $routeId);
    }

    // Relations
    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function ship(): BelongsTo
    {
        return $this->belongsTo(Ship::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Accessors
    public function getDepartureTimeFormattedAttribute(): string
    {
        return Carbon::parse($this->departure_time)->format('H:i');
    }

    public function getArrivalTimeFormattedAttribute(): string
    {
        return Carbon::parse($this->arrival_time)->format('H:i');
    }

    public function getDaysLabelAttribute(): string
    {
        if (! $this->days_of_week) {
            return 'Setiap Hari';
        }

        $days = [
            1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam',
            5 => 'Jum', 6 => 'Sab', 0 => 'Min',
        ];

        if (count($this->days_of_week) === 7) {
            return 'Setiap Hari';
        }

        return collect($this->days_of_week)
            ->map(fn ($day) => $days[$day] ?? '')
            ->implode(', ');
    }

    public function getPriceFormattedAttribute(): string
    {
        return 'Rp '.number_format($this->price, 0, ',', '.');
    }

    public function isAvailableOn(string $date): bool
    {
        $carbonDate = Carbon::parse($date);
        $dayOfWeek = $carbonDate->dayOfWeek;

        $isValidFrom = ! $this->valid_from || $carbonDate->gte($this->valid_from);
        $isValidUntil = ! $this->valid_until || $carbonDate->lte($this->valid_until);
        $runsOnDay = ! $this->days_of_week || in_array($dayOfWeek, $this->days_of_week);

        return $this->is_active && $isValidFrom && $isValidUntil && $runsOnDay;
    }
}
