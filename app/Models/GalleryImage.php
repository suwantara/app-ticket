<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Get the disk used for image storage
     */
    protected function getImageDisk(): string
    {
        return env('CLOUDINARY_URL') ? 'cloudinary' : 'public';
    }

    public function getImageUrlAttribute()
    {
        if (! $this->image_path) {
            return asset('images/placeholder.png');
        }

        // If already a full URL, return as-is
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return Storage::disk($this->getImageDisk())->url($this->image_path);
    }
}
