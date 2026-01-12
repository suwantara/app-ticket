<?php

use App\Models\Destination;
use App\Models\GalleryImage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can access gallery index page', function () {
    $response = $this->get('/destinations/gallery/all');
    
    $response->assertOk();
    $response->assertSee('Galeri Destinasi');
});

it('can access gallery for specific destination', function () {
    $destination = Destination::factory()->create();
    
    $response = $this->get('/destinations/gallery/' . $destination->id);
    
    $response->assertOk();
    $response->assertSee('Galeri ' . $destination->name);
});

it('shows gallery images', function () {
    $galleryImage = GalleryImage::factory()->create();
    
    $response = $this->get('/destinations/gallery/all');
    
    $response->assertOk();
    $response->assertSee($galleryImage->caption);
});

it('maintains backward compatibility', function () {
    $response = $this->get('/destinations/gallery');
    
    $response->assertOk();
    $response->assertSee('Galeri Destinasi');
});