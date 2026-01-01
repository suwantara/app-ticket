<?php

namespace App\View\Components;

use App\Models\Page;
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
        $this->navbarPages = Page::published()
            ->inNavbar()
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
