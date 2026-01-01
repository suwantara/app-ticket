<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Schedule;
use App\Models\Ship;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Ships
        $ships = [
            [
                'name' => 'Express Bahari 1',
                'code' => 'EB-01',
                'description' => 'Fast boat modern dengan fasilitas lengkap dan nyaman untuk perjalanan ke Nusa Penida dan Lembongan.',
                'capacity' => 80,
                'facilities' => ['AC', 'Toilet', 'Life Jacket', 'Asuransi', 'Bagasi', 'Air Mineral'],
                'operator' => 'Express Bahari',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Express Bahari 2',
                'code' => 'EB-02',
                'description' => 'Kapal cepat dengan kapasitas besar untuk rute Sanur - Nusa Penida.',
                'capacity' => 100,
                'facilities' => ['AC', 'Toilet', 'Life Jacket', 'Asuransi', 'Bagasi', 'Air Mineral', 'TV'],
                'operator' => 'Express Bahari',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Marlin Fastboat',
                'code' => 'MF-01',
                'description' => 'Kapal cepat premium untuk rute Padang Bai - Gili Islands.',
                'capacity' => 60,
                'facilities' => ['AC', 'Toilet', 'Life Jacket', 'Asuransi', 'Bagasi', 'Snack', 'Air Mineral'],
                'operator' => 'Marlin Cruise',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Gili Getaway',
                'code' => 'GG-01',
                'description' => 'Fast boat langsung dari Sanur ke Gili Trawangan tanpa transit.',
                'capacity' => 70,
                'facilities' => ['AC', 'Toilet', 'Life Jacket', 'Asuransi', 'Bagasi', 'USB Charger', 'WiFi'],
                'operator' => 'Gili Getaway',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Scoot Fast Cruises',
                'code' => 'SC-01',
                'description' => 'Kapal cepat dengan deck terbuka untuk menikmati pemandangan laut.',
                'capacity' => 50,
                'facilities' => ['AC', 'Toilet', 'Life Jacket', 'Asuransi', 'Deck Terbuka', 'Musik'],
                'operator' => 'Scoot Cruises',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Angel Billabong',
                'code' => 'AB-01',
                'description' => 'Fast boat ekonomis untuk perjalanan ke Nusa Penida.',
                'capacity' => 45,
                'facilities' => ['Life Jacket', 'Asuransi', 'Bagasi'],
                'operator' => 'Angel Billabong Tours',
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($ships as $ship) {
            Ship::create($ship);
        }

        // Get ships for scheduling
        $eb1 = Ship::where('code', 'EB-01')->first();
        $eb2 = Ship::where('code', 'EB-02')->first();
        $mf1 = Ship::where('code', 'MF-01')->first();
        $gg1 = Ship::where('code', 'GG-01')->first();
        $sc1 = Ship::where('code', 'SC-01')->first();
        $ab1 = Ship::where('code', 'AB-01')->first();

        // Get routes
        $sanurNp = Route::where('code', 'SAN-NP')->first();
        $sanurNl = Route::where('code', 'SAN-NL')->first();
        $sanurGt = Route::where('code', 'SAN-GT')->first();
        $pbGt = Route::where('code', 'PB-GT')->first();
        $pbGa = Route::where('code', 'PB-GA')->first();
        $npSanur = Route::where('code', 'NP-SAN')->first();
        $nlSanur = Route::where('code', 'NL-SAN')->first();
        $gtSanur = Route::where('code', 'GT-SAN')->first();

        $allDays = [0, 1, 2, 3, 4, 5, 6];

        $schedules = [
            // Sanur -> Nusa Penida (Multiple departures)
            [
                'route_id' => $sanurNp?->id,
                'ship_id' => $eb1?->id,
                'departure_time' => '07:30',
                'arrival_time' => '08:15',
                'price' => 150000,
                'available_seats' => 80,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
            [
                'route_id' => $sanurNp?->id,
                'ship_id' => $eb2?->id,
                'departure_time' => '08:30',
                'arrival_time' => '09:15',
                'price' => 175000,
                'available_seats' => 100,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
            [
                'route_id' => $sanurNp?->id,
                'ship_id' => $ab1?->id,
                'departure_time' => '09:30',
                'arrival_time' => '10:15',
                'price' => 125000,
                'available_seats' => 45,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
            [
                'route_id' => $sanurNp?->id,
                'ship_id' => $eb1?->id,
                'departure_time' => '11:00',
                'arrival_time' => '11:45',
                'price' => 150000,
                'available_seats' => 80,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
            [
                'route_id' => $sanurNp?->id,
                'ship_id' => $sc1?->id,
                'departure_time' => '14:00',
                'arrival_time' => '14:45',
                'price' => 135000,
                'available_seats' => 50,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],

            // Nusa Penida -> Sanur (Return trips)
            [
                'route_id' => $npSanur?->id,
                'ship_id' => $eb1?->id,
                'departure_time' => '10:00',
                'arrival_time' => '10:45',
                'price' => 150000,
                'available_seats' => 80,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
            [
                'route_id' => $npSanur?->id,
                'ship_id' => $eb2?->id,
                'departure_time' => '12:00',
                'arrival_time' => '12:45',
                'price' => 175000,
                'available_seats' => 100,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
            [
                'route_id' => $npSanur?->id,
                'ship_id' => $ab1?->id,
                'departure_time' => '15:00',
                'arrival_time' => '15:45',
                'price' => 125000,
                'available_seats' => 45,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
            [
                'route_id' => $npSanur?->id,
                'ship_id' => $sc1?->id,
                'departure_time' => '16:30',
                'arrival_time' => '17:15',
                'price' => 135000,
                'available_seats' => 50,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],

            // Sanur -> Nusa Lembongan
            [
                'route_id' => $sanurNl?->id,
                'ship_id' => $eb1?->id,
                'departure_time' => '08:00',
                'arrival_time' => '08:30',
                'price' => 125000,
                'available_seats' => 80,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
            [
                'route_id' => $sanurNl?->id,
                'ship_id' => $sc1?->id,
                'departure_time' => '10:30',
                'arrival_time' => '11:00',
                'price' => 110000,
                'available_seats' => 50,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],

            // Nusa Lembongan -> Sanur
            [
                'route_id' => $nlSanur?->id,
                'ship_id' => $eb1?->id,
                'departure_time' => '14:00',
                'arrival_time' => '14:30',
                'price' => 125000,
                'available_seats' => 80,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
            [
                'route_id' => $nlSanur?->id,
                'ship_id' => $sc1?->id,
                'departure_time' => '16:00',
                'arrival_time' => '16:30',
                'price' => 110000,
                'available_seats' => 50,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],

            // Sanur -> Gili Trawangan
            [
                'route_id' => $sanurGt?->id,
                'ship_id' => $gg1?->id,
                'departure_time' => '08:00',
                'arrival_time' => '10:30',
                'price' => 650000,
                'available_seats' => 70,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],

            // Gili Trawangan -> Sanur
            [
                'route_id' => $gtSanur?->id,
                'ship_id' => $gg1?->id,
                'departure_time' => '12:30',
                'arrival_time' => '15:00',
                'price' => 650000,
                'available_seats' => 70,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],

            // Padang Bai -> Gili Trawangan
            [
                'route_id' => $pbGt?->id,
                'ship_id' => $mf1?->id,
                'departure_time' => '09:00',
                'arrival_time' => '10:30',
                'price' => 450000,
                'available_seats' => 60,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
            [
                'route_id' => $pbGt?->id,
                'ship_id' => $mf1?->id,
                'departure_time' => '13:00',
                'arrival_time' => '14:30',
                'price' => 450000,
                'available_seats' => 60,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],

            // Padang Bai -> Gili Air
            [
                'route_id' => $pbGa?->id,
                'ship_id' => $mf1?->id,
                'departure_time' => '09:00',
                'arrival_time' => '10:25',
                'price' => 450000,
                'available_seats' => 60,
                'days_of_week' => $allDays,
                'is_active' => true,
            ],
        ];

        foreach ($schedules as $schedule) {
            if ($schedule['route_id'] && $schedule['ship_id']) {
                Schedule::create($schedule);
            }
        }
    }
}
