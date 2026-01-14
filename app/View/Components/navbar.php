<?php

namespace App\View\Components;

// Navbar uses static menu now; no cache lookup for pages
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public $navbarPages;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Static menu: no dynamic pages
        $this->navbarPages = [];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
