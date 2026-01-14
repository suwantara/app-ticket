<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed staff/admin users first
        $this->call(StaffSeeder::class);

        // Seed sample destinations
        $this->call(DestinationSeeder::class);

        // Seed schedules (ships, routes, schedules)
        $this->call(ScheduleSeeder::class);
    }
}
