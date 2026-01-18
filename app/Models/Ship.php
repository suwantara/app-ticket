<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Ship extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'image',
        'capacity',
        'facilities',
        'operator',
        'operator_logo',
        'is_active',
        'order',
    ];

    protected $casts = [
        'facilities' => 'array',
        'is_active' => 'boolean',
        'capacity' => 'integer',
    ];

    /**
     * Get the disk used for image storage
     */
    protected function getImageDisk(): string
    {
        return env('CLOUDINARY_URL') ? 'cloudinary' : 'public';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Relations
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    // Accessors
    public function getCapacityLabelAttribute(): string
    {
        return $this->capacity . ' penumpang';
    }

    /**
     * Get the full URL for the ship image
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return Storage::disk($this->getImageDisk())->url($this->image);
    }

    /**
     * Get the full URL for the operator logo
     */
    public function getOperatorLogoUrlAttribute(): ?string
    {
        if (!$this->operator_logo) {
            return null;
        }

        return Storage::disk($this->getImageDisk())->url($this->operator_logo);
    }
}
