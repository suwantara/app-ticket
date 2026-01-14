<?php

namespace App\Repositories;

use App\Models\GalleryImage;
use App\Models\Destination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GalleryRepository
{
    /**
     * Get all gallery images with pagination.
     */
    public function getAllPaginated(int $perPage = 16): LengthAwarePaginator
    {
        return GalleryImage::with('destination')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get gallery images for a specific destination.
     */
    public function getByDestination(Destination $destination, int $perPage = 12): LengthAwarePaginator
    {
        return $destination->galleryImages()
            ->with('destination')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get gallery images with destination filter.
     */
    public function getWithDestinationFilter(?int $destinationId = null, int $perPage = 16): LengthAwarePaginator
    {
        $query = GalleryImage::with('destination');

        if ($destinationId) {
            $query->where('destination_id', $destinationId);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get latest gallery images for a destination (for display on destination page).
     */
    public function getLatestForDestination(Destination $destination, int $limit = 8): Collection
    {
        return $destination->galleryImages()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get destinations that have gallery images.
     */
    public function getDestinationsWithGallery(): Collection
    {
        return Destination::active()
            ->has('galleryImages')
            ->get();
    }
}
