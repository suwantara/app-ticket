<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'origin_id',
        'destination_id',
        'distance',
        'duration',
        'base_price',
        'description',
        'is_active',
        'order',
    ];

    protected $casts = [
        'distance' => 'decimal:2',
        'duration' => 'integer',
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the origin destination
     */
    public function origin(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'origin_id');
    }

    /**
     * Get the destination
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    /**
     * Scope for active routes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get formatted duration (e.g., "1j 30m")
     */
    public function getFormattedDurationAttribute(): string
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}j {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}j";
        }
        return "{$minutes}m";
    }

    /**
     * Get route name (e.g., "Sanur → Nusa Penida")
     */
    public function getRouteNameAttribute(): string
    {
        return "{$this->origin->name} → {$this->destination->name}";
    }
}
