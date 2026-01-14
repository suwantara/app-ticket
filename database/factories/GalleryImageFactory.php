<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalleryImage>
 */
class GalleryImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_path' => 'gallery/'.fake()->uuid().'.jpg',
            'caption' => fake()->sentence(),
            'destination_id' => null,
        ];
    }

    /**
     * Indicate that the gallery image has a destination.
     */
    public function withDestination($destinationId): static
    {
        return $this->state(fn (array $attributes) => [
            'destination_id' => $destinationId,
        ]);
    }
}
