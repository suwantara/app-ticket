<?php

namespace App\Http\Controllers;

use App\Models\Order;

class PageController extends Controller
{
    /**
     * Display the home page
     */
    public function home()
    {
        // Static fallback for home page (DB-driven pages removed)
        $page = (object) [
            'title' => 'Home',
            'meta_title' => 'Home',
            'meta_description' => 'Selamat datang di layanan tiket kapal cepat kami.',
            'featured_image' => null,
            'content' => null,
        ];

        return view('pages.home', compact('page'));
    }

    /**
     * Display the ticket booking page
     */
    public function ticket()
    {
        return view('pages.ticket');
    }

    /**
     * Display the about page
     */
    public function about()
    {
        // Dummy data for static view
        $page = (object) [
            'title' => 'Tentang Kami',
            'meta_title' => 'Tentang Kami',
            'meta_description' => 'Informasi tentang layanan dan perusahaan kami.',
            'featured_image' => null,
            'content' => '<p>Selamat datang di layanan tiket kapal cepat terbaik. Kami melayani rute destinasi populer dengan armada modern dan pelayanan ramah.</p>',
        ];

        return view('pages.about', compact('page'));
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        // Dummy data for static view
        $page = (object) [
            'title' => 'Hubungi Kami',
            'meta_title' => 'Hubungi Kami',
            'meta_description' => 'Silakan hubungi kami untuk pertanyaan, bantuan, atau kerjasama.',
            'featured_image' => null,
            'content' => '<p>Tim kami siap membantu Anda setiap hari. Hubungi kami melalui email, telepon, atau kunjungi kantor kami di Bali.</p>',
        ];

        return view('pages.contact', compact('page'));
    }

    /**
     * Display booking confirmation page
     */
    public function bookingConfirmation(Order $order)
    {
        // Load relationships for display
        $order->load(['schedule.route.origin', 'schedule.route.destination', 'schedule.ship', 'passengers']);

        return view('pages.booking-confirmation', compact('order'));
    }

    /**
     * Display a dynamic page by slug
     */
    public function show(string $slug)
    {
        // Dynamic CMS pages have been removed. Return 404 for old page URLs.
        abort(404);
    }
}
