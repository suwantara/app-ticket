<?php

namespace App\Http\Controllers;

use App\Repositories\GalleryRepository;
use App\Models\Destination;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected GalleryRepository $galleryRepository;

    public function __construct(GalleryRepository $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
    }

    /**
     * Display gallery images.
     */
    public function index(Request $request)
    {
        $destinationId = $request->get('destination');

        $images = $this->galleryRepository->getWithDestinationFilter($destinationId);
        $destinations = $this->galleryRepository->getDestinationsWithGallery();

        return view('pages.destinations.gallery', [
            'images' => $images,
            'destinations' => $destinations,
        ]);
    }

    /**
     * Display gallery for a specific destination.
     */
    public function show(Destination $destination)
    {
        $images = $this->galleryRepository->getByDestination($destination);
        $destinations = $this->galleryRepository->getDestinationsWithGallery();

        return view('pages.destinations.gallery', [
            'images' => $images,
            'currentDestination' => $destination,
            'destinations' => $destinations,
        ]);
    }
}
