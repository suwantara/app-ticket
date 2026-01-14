<?php

use App\Models\Destination;
use App\Models\GalleryImage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can access gallery index page at /gallery', function () {
    $response = $this->get('/gallery');
    
    $response->assertOk();
    $response->assertSee('Galeri Destinasi');
});

it('can access gallery for specific destination', function () {
    $destination = Destination::factory()->create();
    
    $response = $this->get('/gallery/' . $destination->id);
    
    $response->assertOk();
    $response->assertSee('Galeri ' . $destination->name);
});

it('shows gallery images', function () {
    $galleryImage = GalleryImage::factory()->create();
    
    $response = $this->get('/gallery');
    
    $response->assertOk();
    $response->assertSee($galleryImage->caption);
});

it('destination page links to gallery', function () {
    $destination = Destination::factory()->create();
    $galleryImage = GalleryImage::factory()->create(['destination_id' => $destination->id]);
    
    $response = $this->get(route('destinations.show', $destination->slug));
    
    $response->assertOk();
    $response->assertSee('Galeri ' . $destination->name);
    $response->assertSee(route('gallery.show', $destination));
});