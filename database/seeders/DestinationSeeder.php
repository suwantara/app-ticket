<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Route;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Harbors
        $harbors = [
            [
                'name' => 'Sanur',
                'slug' => 'sanur',
                'description' => 'Sanur adalah pelabuhan utama untuk perjalanan fast boat ke Nusa Penida, Nusa Lembongan, dan Gili. Terletak di pantai timur Bali dengan akses mudah dari Bandara Ngurah Rai.',
                'short_description' => 'Pelabuhan utama fast boat di Bali Timur',
                'location' => 'Bali, Indonesia',
                'latitude' => -8.6783,
                'longitude' => 115.2614,
                'type' => 'harbor',
                'facilities' => ['Parkir', 'Toilet', 'Warung Makan', 'Mushola', 'Ruang Tunggu'],
                'highlights' => ['Akses mudah dari Bandara', 'Banyak pilihan fast boat', 'Pantai bersih'],
                'is_popular' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Padang Bai',
                'slug' => 'padang-bai',
                'description' => 'Padang Bai adalah pelabuhan di Bali Timur yang melayani penyeberangan ke Lombok dan Gili Islands. Dikenal dengan pantai tersembunyi yang indah.',
                'short_description' => 'Pelabuhan ferry dan fast boat ke Lombok',
                'location' => 'Karangasem, Bali',
                'latitude' => -8.5338,
                'longitude' => 115.5088,
                'type' => 'harbor',
                'facilities' => ['Parkir Luas', 'Terminal', 'Restoran', 'ATM', 'Money Changer'],
                'highlights' => ['Blue Lagoon Beach', 'Bias Tugel Beach', 'Diving spot'],
                'is_popular' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Serangan',
                'slug' => 'serangan',
                'description' => 'Pelabuhan Serangan terletak di Pulau Serangan, Denpasar. Alternatif keberangkatan ke Nusa Penida dengan lokasi yang lebih tenang.',
                'short_description' => 'Pelabuhan alternatif di Pulau Serangan',
                'location' => 'Denpasar, Bali',
                'latitude' => -8.7369,
                'longitude' => 115.2314,
                'type' => 'harbor',
                'facilities' => ['Parkir', 'Toilet', 'Warung'],
                'highlights' => ['Lebih sepi', 'Perjalanan lebih pendek', 'View pulau'],
                'is_popular' => false,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Bangsal',
                'slug' => 'bangsal',
                'description' => 'Bangsal adalah pelabuhan utama di Lombok untuk perjalanan ke Gili Trawangan, Gili Air, dan Gili Meno. Terletak di pesisir barat laut Lombok.',
                'short_description' => 'Pelabuhan ke 3 Gili di Lombok',
                'location' => 'Lombok Utara, NTB',
                'latitude' => -8.3521,
                'longitude' => 116.0762,
                'type' => 'harbor',
                'facilities' => ['Parkir', 'Ticket Counter', 'Warung', 'Toilet'],
                'highlights' => ['Akses ke 3 Gili', 'Public boat murah', 'Pemandangan Gili'],
                'is_popular' => true,
                'is_active' => true,
                'order' => 4,
            ],
        ];

        // Islands
        $islands = [
            [
                'name' => 'Nusa Penida',
                'slug' => 'nusa-penida',
                'description' => 'Nusa Penida adalah pulau terbesar dari tiga pulau Nusa di tenggara Bali. Terkenal dengan pemandangan tebing dramatis, pantai eksotis seperti Kelingking Beach, dan spot snorkeling dengan Manta Ray.',
                'short_description' => 'Pulau eksotis dengan tebing dramatis',
                'image' => 'https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?w=800',
                'location' => 'Klungkung, Bali',
                'latitude' => -8.7275,
                'longitude' => 115.5444,
                'type' => 'island',
                'facilities' => ['Pelabuhan', 'Penginapan', 'Restoran', 'Rental Motor', 'Tour Guide'],
                'highlights' => ['Kelingking Beach', 'Angels Billabong', 'Broken Beach', 'Crystal Bay', 'Manta Point'],
                'is_popular' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Nusa Lembongan',
                'slug' => 'nusa-lembongan',
                'description' => 'Nusa Lembongan adalah pulau kecil yang tenang dengan pantai berpasir putih, spot surfing, dan laguna biru. Terhubung dengan jembatan ke Nusa Ceningan.',
                'short_description' => 'Pulau kecil dengan suasana santai',
                'image' => 'https://images.unsplash.com/photo-1559628376-f3fe5f782a2e?w=800',
                'location' => 'Klungkung, Bali',
                'latitude' => -8.6795,
                'longitude' => 115.4469,
                'type' => 'island',
                'facilities' => ['Beach Club', 'Resort', 'Diving Center', 'Surfing Spot', 'Kayak Rental'],
                'highlights' => ['Dream Beach', 'Devils Tear', 'Mangrove Forest', 'Yellow Bridge', 'Sunset Point'],
                'is_popular' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Gili Trawangan',
                'slug' => 'gili-trawangan',
                'description' => 'Gili Trawangan adalah pulau terbesar dari tiga Gili di Lombok. Dikenal sebagai party island dengan nightlife, diving, dan pantai putih tanpa kendaraan bermotor.',
                'short_description' => 'Party island dengan nightlife terbaik',
                'image' => 'https://images.unsplash.com/photo-1573790387438-4da905039392?w=800',
                'location' => 'Lombok Utara, NTB',
                'latitude' => -8.3508,
                'longitude' => 116.0340,
                'type' => 'island',
                'facilities' => ['Resort', 'Bar', 'Diving Center', 'Snorkeling', 'Horse Riding'],
                'highlights' => ['Sunset Swing', 'Underwater Statues', 'Night Market', 'Turtle Point', 'Shark Point'],
                'is_popular' => true,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Gili Air',
                'slug' => 'gili-air',
                'description' => 'Gili Air menawarkan keseimbangan sempurna antara ketenangan dan aktivitas. Cocok untuk keluarga dengan suasana yang lebih santai dari Gili Trawangan.',
                'short_description' => 'Pulau santai untuk keluarga',
                'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=800',
                'location' => 'Lombok Utara, NTB',
                'latitude' => -8.3577,
                'longitude' => 116.0824,
                'type' => 'island',
                'facilities' => ['Resort', 'Yoga Studio', 'Diving', 'Snorkeling', 'Spa'],
                'highlights' => ['Sunrise View', 'Turtle Sanctuary', 'Coral Garden', 'Beach Bars', 'Local Village'],
                'is_popular' => true,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Gili Meno',
                'slug' => 'gili-meno',
                'description' => 'Gili Meno adalah pulau paling tenang dan romantis dari tiga Gili. Ideal untuk honeymoon dengan pantai sepi dan danau air asin.',
                'short_description' => 'Pulau honeymoon paling romantis',
                'image' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?w=800',
                'location' => 'Lombok Utara, NTB',
                'latitude' => -8.3475,
                'longitude' => 116.0571,
                'type' => 'island',
                'facilities' => ['Boutique Resort', 'Spa', 'Snorkeling', 'Bird Park'],
                'highlights' => ['Salt Lake', 'Turtle Hatchery', 'Nest Statues', 'Private Beaches', 'Stargazing'],
                'is_popular' => false,
                'is_active' => true,
                'order' => 5,
            ],
        ];

        // Insert or update destinations (avoid duplicate key error)
        foreach (array_merge($harbors, $islands) as $destination) {
            Destination::updateOrCreate(
                ['slug' => $destination['slug']],
                $destination
            );
        }

        // Create routes
        $this->createRoutes();
    }

    private function createRoutes(): void
    {
        $sanur = Destination::where('slug', 'sanur')->first();
        $padangBai = Destination::where('slug', 'padang-bai')->first();
        $serangan = Destination::where('slug', 'serangan')->first();
        $bangsal = Destination::where('slug', 'bangsal')->first();

        $nusaPenida = Destination::where('slug', 'nusa-penida')->first();
        $nusaLembongan = Destination::where('slug', 'nusa-lembongan')->first();
        $giliTrawangan = Destination::where('slug', 'gili-trawangan')->first();
        $giliAir = Destination::where('slug', 'gili-air')->first();
        $giliMeno = Destination::where('slug', 'gili-meno')->first();

        $routes = [
            // Sanur routes
            [
                'code' => 'SAN-NP',
                'origin_id' => $sanur->id,
                'destination_id' => $nusaPenida->id,
                'distance' => 18,
                'duration' => 45,
                'base_price' => 150000,
                'description' => 'Fast boat dari Sanur ke Nusa Penida',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'code' => 'SAN-NL',
                'origin_id' => $sanur->id,
                'destination_id' => $nusaLembongan->id,
                'distance' => 12,
                'duration' => 30,
                'base_price' => 125000,
                'description' => 'Fast boat dari Sanur ke Nusa Lembongan',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'code' => 'SAN-GT',
                'origin_id' => $sanur->id,
                'destination_id' => $giliTrawangan->id,
                'distance' => 85,
                'duration' => 150,
                'base_price' => 650000,
                'description' => 'Fast boat dari Sanur ke Gili Trawangan via laut',
                'is_active' => true,
                'order' => 3,
            ],

            // Serangan routes
            [
                'code' => 'SER-NP',
                'origin_id' => $serangan->id,
                'destination_id' => $nusaPenida->id,
                'distance' => 15,
                'duration' => 35,
                'base_price' => 135000,
                'description' => 'Fast boat dari Serangan ke Nusa Penida',
                'is_active' => true,
                'order' => 4,
            ],

            // Padang Bai routes
            [
                'code' => 'PB-GT',
                'origin_id' => $padangBai->id,
                'destination_id' => $giliTrawangan->id,
                'distance' => 55,
                'duration' => 90,
                'base_price' => 450000,
                'description' => 'Fast boat dari Padang Bai ke Gili Trawangan',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'code' => 'PB-GA',
                'origin_id' => $padangBai->id,
                'destination_id' => $giliAir->id,
                'distance' => 52,
                'duration' => 85,
                'base_price' => 450000,
                'description' => 'Fast boat dari Padang Bai ke Gili Air',
                'is_active' => true,
                'order' => 6,
            ],

            // Bangsal routes
            [
                'code' => 'BAN-GT',
                'origin_id' => $bangsal->id,
                'destination_id' => $giliTrawangan->id,
                'distance' => 8,
                'duration' => 15,
                'base_price' => 50000,
                'description' => 'Public boat dari Bangsal ke Gili Trawangan',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'code' => 'BAN-GA',
                'origin_id' => $bangsal->id,
                'destination_id' => $giliAir->id,
                'distance' => 5,
                'duration' => 10,
                'base_price' => 35000,
                'description' => 'Public boat dari Bangsal ke Gili Air',
                'is_active' => true,
                'order' => 8,
            ],
            [
                'code' => 'BAN-GM',
                'origin_id' => $bangsal->id,
                'destination_id' => $giliMeno->id,
                'distance' => 6,
                'duration' => 12,
                'base_price' => 40000,
                'description' => 'Public boat dari Bangsal ke Gili Meno',
                'is_active' => true,
                'order' => 9,
            ],

            // Return routes (pulang)
            [
                'code' => 'NP-SAN',
                'origin_id' => $nusaPenida->id,
                'destination_id' => $sanur->id,
                'distance' => 18,
                'duration' => 45,
                'base_price' => 150000,
                'description' => 'Fast boat dari Nusa Penida ke Sanur',
                'is_active' => true,
                'order' => 10,
            ],
            [
                'code' => 'NL-SAN',
                'origin_id' => $nusaLembongan->id,
                'destination_id' => $sanur->id,
                'distance' => 12,
                'duration' => 30,
                'base_price' => 125000,
                'description' => 'Fast boat dari Nusa Lembongan ke Sanur',
                'is_active' => true,
                'order' => 11,
            ],
            [
                'code' => 'GT-SAN',
                'origin_id' => $giliTrawangan->id,
                'destination_id' => $sanur->id,
                'distance' => 85,
                'duration' => 150,
                'base_price' => 650000,
                'description' => 'Fast boat dari Gili Trawangan ke Sanur',
                'is_active' => true,
                'order' => 12,
            ],
        ];

        foreach ($routes as $route) {
            Route::updateOrCreate(
                ['code' => $route['code']],
                $route
            );
        }
    }
}
