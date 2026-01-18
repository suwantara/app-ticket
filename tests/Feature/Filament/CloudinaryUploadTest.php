<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Resources\Destinations\Pages\CreateDestination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class CloudinaryUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_upload_image_to_cloudinary_disk_on_create_destination()
    {
        // 1. Authenticate as Admin
        $user = User::factory()->create(['email' => 'admin@example.com']);
        $this->actingAs($user);

        // 2. Mock Cloudinary Disk
        // Detect Cloudinary environment or force it for testing
        config(['filesystems.disks.cloudinary' => [
            'driver' => 'local', // Use local driver for the fake disk to avoid needing actual Cloudinary adapter
            'root' => storage_path('framework/testing/disks/cloudinary'),
        ]]);

        // Force the form to use 'cloudinary' disk by simulating the env var presence
        // Note: We can't easily change env() results at runtime in some stacks,
        // but we can ensure the Logic in the Form uses a value we can control if we refactored it to use config().
        // However, since it uses env(), we might need to rely on phpunit.xml or putenv.
        putenv('CLOUDINARY_URL=cloudinary://fake:fake@fake');

        Storage::fake('cloudinary');

        // 3. Fake Image
        $file = UploadedFile::fake()->image('bali-beach.jpg');

        // 4. Simulate Filament Create Page
        Livewire::test(CreateDestination::class)
            ->fillForm([
                'name' => 'Sanur Beach',
                'description' => 'Beautiful beach in Bali',
                'slug' => 'sanur-beach',
                'price' => 150000,
                'image' => $file,
                'location' => 'Bali, Indonesia', // Add required fields
            ])
            ->call('create')
            ->assertHasNoErrors();

        // 5. Assert File Exists in "Cloudinary" (Faked) Disk
        // Note: Filament stores temp files then moves them.
        // We check if any file exists in the destinations directory.
        $files = Storage::disk('cloudinary')->allFiles('destinations');
        $this->assertNotEmpty($files, 'File should be stored in destinations directory on cloudinary disk');

        // 6. Assert Database has the record
        $this->assertDatabaseHas('destinations', [
            'name' => 'Sanur Beach',
            'slug' => 'sanur-beach',
        ]);

        // Verify the image path in DB matches a file in storage
        $destination = \App\Models\Destination::where('slug', 'sanur-beach')->first();
        $this->assertNotNull($destination->image);
        Storage::disk('cloudinary')->assertExists($destination->image);
    }
}
