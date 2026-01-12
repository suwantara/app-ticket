<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->city();

        return [
            'name' => $name,
            'slug' => str()->slug($name),
            'description' => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(),
            'image' => 'destinations/' . fake()->uuid() . '.jpg',
            'gallery' => null,
            'location' => fake()->address(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'type' => fake()->randomElement(['island', 'harbor', 'city']),
            'facilities' => fake()->randomElements(['WiFi', 'Restoran', 'Parkir', 'Toilet', 'Mushola', 'ATM'], 3),
            'highlights' => fake()->randomElements(['Pemandangan Indah', 'Akses Mudah', 'Harga Terjangkau', 'Fasilitas Lengkap'], 2),
            'is_popular' => fake()->boolean(30),
            'is_active' => true,
            'order' => fake()->numberBetween(1, 100),
        ];
    }

    /**
     * Indicate that the destination is an island.
     */
    public function island(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'island',
        ]);
    }

    /**
     * Indicate that the destination is a harbor.
     */
    public function harbor(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'harbor',
        ]);
    }

    /**
     * Indicate that the destination is popular.
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_popular' => true,
        ]);
    }

    /**
     * Indicate that the destination is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
