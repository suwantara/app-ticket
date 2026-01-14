<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'image',
        'gallery',
        'location',
        'latitude',
        'longitude',
        'type',
        'facilities',
        'highlights',
        'is_popular',
        'is_active',
        'order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'facilities' => 'array',
        'highlights' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get routes originating from this destination
     */
    public function routesFrom(): HasMany
    {
        return $this->hasMany(Route::class, 'origin_id');
    }

    /**
     * Get routes going to this destination
     */
    public function routesTo(): HasMany
    {
        return $this->hasMany(Route::class, 'destination_id');
    }

    /**
     * Get gallery images for this destination
     */
    public function galleryImages(): HasMany
    {
        return $this->hasMany(GalleryImage::class, 'destination_id');
    }

    /**
     * Scope for active destinations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for popular destinations
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Scope for harbor type destinations
     */
    public function scopeHarbors($query)
    {
        return $query->where('type', 'harbor');
    }

    /**
     * Scope for island type destinations
     */
    public function scopeIslands($query)
    {
        return $query->where('type', 'island');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
