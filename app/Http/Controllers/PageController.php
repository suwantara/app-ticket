<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the home page
     */
    public function home()
    {
        $page = Page::where('slug', 'home')->published()->first();

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
        $page = Page::where('slug', 'about')->published()->firstOrFail();

        return view('pages.about', compact('page'));
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        $page = Page::where('slug', 'contact')->published()->firstOrFail();

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
    public function show(Page $page)
    {
        if (!$page->is_published) {
            abort(404);
        }

        // Determine which template to use
        $template = $page->template ?? 'default';
        $viewName = "pages.templates.{$template}";

        // Fallback to default template if specific one doesn't exist
        if (!view()->exists($viewName)) {
            $viewName = 'pages.templates.default';
        }

        return view($viewName, compact('page'));
    }
}
