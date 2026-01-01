<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
