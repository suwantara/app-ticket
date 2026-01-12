<?php

use App\Models\Destination;
use App\Models\GalleryImage;
use App\Repositories\GalleryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('gallery repository returns paginated images', function () {
    // Create test data
    $destination = Destination::factory()->create();
    GalleryImage::factory()->count(5)->create(['destination_id' => $destination->id]);
    GalleryImage::factory()->count(3)->create();
    
    $repository = new GalleryRepository();
    
    // Test getAllPaginated
    $images = $repository->getAllPaginated(10);
    expect($images)->toBeInstanceOf(Illuminate\Contracts\Pagination\LengthAwarePaginator::class)
        ->and($images->count())->toBe(8);
    
    // Test getByDestination
    $destinationImages = $repository->getByDestination($destination, 10);
    expect($destinationImages->count())->toBe(5);
    
    // Test getDestinationsWithGallery
    $destinations = $repository->getDestinationsWithGallery();
    expect($destinations->count())->toBe(1);
});

it('gallery controller uses repository via dependency injection', function () {
    // Mock the repository
    $mockRepository = Mockery::mock(GalleryRepository::class);
    $mockRepository->shouldReceive('getWithDestinationFilter')
        ->once()
        ->with(null)
        ->andReturn(new Illuminate\Pagination\LengthAwarePaginator([], 0, 16));
    $mockRepository->shouldReceive('getDestinationsWithGallery')
        ->once()
        ->andReturn(collect([]));
    
    // Create controller with mocked repository
    $controller = new App\Http\Controllers\GalleryController($mockRepository);
    
    // Create mock request
    $request = new Illuminate\Http\Request();
    
    // Call the method
    $response = $controller->index($request);
    
    expect($response)->toBeInstanceOf(Illuminate\View\View::class);
});

it('destination page shows gallery section', function () {
    $destination = Destination::factory()->create();
    $galleryImage = GalleryImage::factory()->create(['destination_id' => $destination->id]);
    
    $response = $this->get(route('destinations.show', $destination->slug));
    
    $response->assertOk();
    
    // Check if gallery section exists
    $response->assertSee('Galeri ' . $destination->name);
    
    // The actual image caption might not be visible if it's truncated or in overlay
    // But we can check for the gallery section structure
    $response->assertSee('grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4');
});