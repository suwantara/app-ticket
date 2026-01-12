<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'sections',
        'meta_title',
        'meta_description',
        'featured_image',
        'is_published',
        'is_in_navbar',
        'navbar_order',
        'template',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_in_navbar' => 'boolean',
        'navbar_order' => 'integer',
        'sections' => 'array',
    ];

    /**
     * Scope for published pages
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for navbar pages
     */
    public function scopeInNavbar($query)
    {
        return $query->where('is_in_navbar', true)->orderBy('navbar_order');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
