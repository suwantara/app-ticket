<?php

use App\Models\Destination;
use App\Models\GalleryImage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('displays gallery index page', function () {
    // Create a gallery image
    $galleryImage = GalleryImage::factory()->create();

    $response = $this->get(route('destinations.gallery.index'));
    $response->assertOk()
        ->assertSee('Galeri Destinasi')
        ->assertSee($galleryImage->caption);
});

it('displays gallery for specific destination', function () {
    // Create destination with gallery images
    $destination = Destination::factory()->create();
    $galleryImage = GalleryImage::factory()->create(['destination_id' => $destination->id]);
    $response = $this->get(route('destinations.gallery.show', $destination));

    $response->assertOk()
        ->assertSee('Galeri ' . $destination->name)
        ->assertSee($galleryImage->caption);
});

it('shows gallery images on destination page', function () {
    // Create destination with gallery images
    $destination = Destination::factory()->create();
    $galleryImage = GalleryImage::factory()->create(['destination_id' => $destination->id]);

    $response = $this->get(route('destinations.show', $destination->slug));

    $response->assertOk()
        ->assertSee('Galeri ' . $destination->name)
        ->assertSee($galleryImage->caption);
});

it('shows empty state when no gallery images', function () {
    $response = $this->get(route('destinations.gallery.index'));

    $response->assertOk()
        ->assertSee('Belum ada gambar galeri');
});

it('links from gallery to destination page', function () {
    $destination = Destination::factory()->create();
    $galleryImage = GalleryImage::factory()->create(['destination_id' => $destination->id]);

    $response = $this->get(route('destinations.gallery.index'));

    $response->assertOk()
        ->assertSee(route('destinations.show', $destination->slug));
});

// Test backward compatibility for old route
it('maintains backward compatibility for old gallery route', function () {
    $galleryImage = GalleryImage::factory()->create();

    $response = $this->get(route('destinations.gallery'));

    $response->assertOk()
        ->assertSee('Galeri Destinasi');
});

