<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'caption',
        'destination_id',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function getImageUrlAttribute()
    {
        if (! $this->image_path) {
            return asset('images/placeholder.png');
        }

        return \Storage::disk('public')->url($this->image_path);
    }
}
