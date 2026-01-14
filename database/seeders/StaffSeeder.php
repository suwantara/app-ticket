<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@kapal.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create staff users
        User::updateOrCreate(
            ['email' => 'staff@kapal.test'],
            [
                'name' => 'Petugas 1',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff2@kapal.test'],
            [
                'name' => 'Petugas 2',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'is_active' => true,
            ]
        );

        // Create sample regular users
        User::updateOrCreate(
            ['email' => 'user@kapal.test'],
            [
                'name' => 'Pengguna Demo',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'siti@gmail.com'],
            [
                'name' => 'Siti Rahayu',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
            ]
        );
    }
}
