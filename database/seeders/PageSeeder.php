<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'content' => '
                    <h2>Selamat Datang di Fast Boat Ticket</h2>
                    <p>Platform pemesanan tiket fast boat terpercaya untuk perjalanan antar pulau di Indonesia. Kami menyediakan layanan pemesanan tiket yang mudah, cepat, dan aman untuk berbagai destinasi populer.</p>

                    <h3>Mengapa Memilih Kami?</h3>
                    <ul>
                        <li><strong>Harga Terjangkau</strong> - Dapatkan harga terbaik untuk perjalanan Anda</li>
                        <li><strong>Pemesanan Mudah</strong> - Proses booking yang simpel dan cepat</li>
                        <li><strong>Layanan 24/7</strong> - Tim support siap membantu kapan saja</li>
                        <li><strong>E-Ticket Instan</strong> - Tiket langsung dikirim ke email Anda</li>
                    </ul>

                    <h3>Destinasi Populer</h3>
                    <p>Jelajahi keindahan pulau-pulau eksotis di Indonesia:</p>
                    <ul>
                        <li>Bali - Nusa Penida</li>
                        <li>Bali - Nusa Lembongan</li>
                        <li>Bali - Gili Trawangan</li>
                        <li>Bali - Lombok</li>
                    </ul>
                ',
                'meta_title' => 'Fast Boat Ticket - Pemesanan Tiket Fast Boat Online',
                'meta_description' => 'Platform pemesanan tiket fast boat terpercaya untuk perjalanan antar pulau di Indonesia. Harga terjangkau, pemesanan mudah, e-ticket instan.',
                'is_published' => true,
                'is_in_navbar' => true,
                'navbar_order' => 1,
                'template' => 'home',
            ],
            [
                'title' => 'Tentang Kami',
                'slug' => 'about',
                'content' => '
                    <h2>Tentang Fast Boat Ticket</h2>
                    <p>Fast Boat Ticket adalah platform pemesanan tiket fast boat online yang berkomitmen untuk memberikan pengalaman perjalanan terbaik bagi wisatawan domestik maupun mancanegara.</p>

                    <h3>Visi Kami</h3>
                    <p>Menjadi platform pemesanan tiket fast boat nomor satu di Indonesia yang menghubungkan wisatawan dengan destinasi impian mereka.</p>

                    <h3>Misi Kami</h3>
                    <ul>
                        <li>Menyediakan layanan pemesanan tiket yang mudah dan terpercaya</li>
                        <li>Memberikan harga kompetitif dengan kualitas layanan terbaik</li>
                        <li>Mengutamakan keamanan dan kenyamanan pelanggan</li>
                        <li>Terus berinovasi untuk meningkatkan pengalaman pengguna</li>
                    </ul>

                    <h3>Tim Kami</h3>
                    <p>Kami adalah tim profesional yang berpengalaman di industri pariwisata dan teknologi. Dengan dedikasi tinggi, kami berkomitmen untuk memberikan layanan terbaik kepada setiap pelanggan.</p>

                    <h3>Keunggulan Kami</h3>
                    <ul>
                        <li><strong>Pengalaman</strong> - Lebih dari 5 tahun melayani ribuan pelanggan</li>
                        <li><strong>Jaringan Luas</strong> - Kerjasama dengan berbagai operator fast boat terpercaya</li>
                        <li><strong>Teknologi Modern</strong> - Sistem pemesanan yang aman dan efisien</li>
                        <li><strong>Layanan Pelanggan</strong> - Tim support yang responsif dan ramah</li>
                    </ul>
                ',
                'meta_title' => 'Tentang Kami - Fast Boat Ticket',
                'meta_description' => 'Pelajari lebih lanjut tentang Fast Boat Ticket, platform pemesanan tiket fast boat online terpercaya di Indonesia.',
                'is_published' => true,
                'is_in_navbar' => true,
                'navbar_order' => 2,
                'template' => 'about',
            ],
            [
                'title' => 'Hubungi Kami',
                'slug' => 'contact',
                'content' => '
                    <h2>Hubungi Kami</h2>
                    <p>Kami siap membantu Anda! Jika ada pertanyaan, saran, atau keluhan, jangan ragu untuk menghubungi tim kami.</p>

                    <h3>Informasi Kontak</h3>
                    <ul>
                        <li><strong>Alamat:</strong> Jl. Raya Kuta No. 123, Bali, Indonesia</li>
                        <li><strong>Telepon:</strong> +62 361 123456</li>
                        <li><strong>WhatsApp:</strong> +62 812 3456 7890</li>
                        <li><strong>Email:</strong> info@fastboatticket.com</li>
                    </ul>

                    <h3>Jam Operasional</h3>
                    <ul>
                        <li><strong>Senin - Jumat:</strong> 08:00 - 20:00 WITA</li>
                        <li><strong>Sabtu - Minggu:</strong> 09:00 - 18:00 WITA</li>
                        <li><strong>Hari Libur:</strong> 09:00 - 15:00 WITA</li>
                    </ul>

                    <h3>Sosial Media</h3>
                    <p>Ikuti kami di sosial media untuk mendapatkan update terbaru dan promo menarik:</p>
                    <ul>
                        <li>Instagram: @fastboatticket</li>
                        <li>Facebook: Fast Boat Ticket</li>
                        <li>Twitter: @fastboatticket</li>
                    </ul>

                    <h3>FAQ</h3>
                    <p>Sebelum menghubungi kami, Anda juga bisa melihat halaman FAQ untuk jawaban atas pertanyaan yang sering diajukan.</p>
                ',
                'meta_title' => 'Hubungi Kami - Fast Boat Ticket',
                'meta_description' => 'Hubungi tim Fast Boat Ticket untuk pertanyaan, pemesanan, atau bantuan. Kami siap membantu 24/7.',
                'is_published' => true,
                'is_in_navbar' => true,
                'navbar_order' => 3,
                'template' => 'contact',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
