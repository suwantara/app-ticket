 <?php

use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('admin can access gallery image management', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);

    $response = $this->actingAs($admin)->get('/admin/gallery-images');

    $response->assertStatus(200);
});

it('staff can access gallery image management', function () {
    $staff = User::factory()->create([
        'role' => 'staff',
        'is_active' => true,
    ]);

    $response = $this->actingAs($staff)->get('/admin/gallery-images');

    $response->assertStatus(200);
});

it('regular user cannot access gallery image management', function () {
    $user = User::factory()->create([
        'role' => 'user',
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->get('/admin/gallery-images');

    $response->assertStatus(403);
});

it('can create gallery image', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);

    $this->actingAs($admin);

    $galleryImage = GalleryImage::create([
        'image_path' => 'test-image.jpg',
        'caption' => 'Test caption',
        'destination_id' => null,
    ]);

    $this->assertDatabaseHas('gallery_images', [
        'id' => $galleryImage->id,
        'caption' => 'Test caption',
    ]);
});

it('can list gallery images', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);

    GalleryImage::factory()->count(3)->create();

    $response = $this->actingAs($admin)->get('/admin/gallery-images');

    $response->assertStatus(200);
    $response->assertSee('Galeri');
});
