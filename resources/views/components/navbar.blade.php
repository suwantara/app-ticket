<nav class="bg-neutral-primary fixed w-full z-20 top-0 start-0 border-b border-default">
    <div class="flex items-center justify-between mx-auto container p-4">
        {{-- Logo (hidden when mobile menu is open) --}}
        <a href="{{ route('home') }}" id="navbar-logo" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/logo-semabu.png') }}" class="h-8" alt="{{ config('app.name') }} Logo" />
        </a>

        {{-- Mobile: Auth + Burger (far right) --}}
        <div class="flex items-center gap-2 md:hidden ml-auto">
            @auth
                <button type="button" class="flex text-sm bg-gray-100 rounded-full focus:ring-4 focus:ring-blue-300"
                    id="user-menu-button-mobile" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <div
                        class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </button>
            @endauth
            <button id="mobile-menu-toggle" data-collapse-toggle="mega-menu-full" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-lg hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-default"
                aria-controls="mega-menu-full" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                </svg>
            </button>
        </div>

        {{-- Desktop Navigation --}}
        <div class="items-center justify-between hidden md:flex md:w-auto md:order-1">
            <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-8 rtl:space-x-reverse">
                <li>
                    <a href="{{ route('home') }}"
                        class="block py-2 px-3 text-heading hover:text-blue-900 border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0"
                        aria-current="page">Beranda</a>
                </li>
                <li>
                    <button id="mega-menu-full-dropdown-button" data-collapse-toggle="mega-menu-full-dropdown"
                        class="flex items-center justify-between w-full py-2 px-3 font-medium text-heading border-b border-light md:w-auto hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">
                        Destinasi
                        <i id="desktop-angle-icon" aria-hidden="true"
                            class="fa-solid fa-angle-down ms-2 transition-transform duration-300"></i>
                    </button>
                </li>
                <li>
                    <a href="{{ route('ticket') }}"
                        class="block py-2 px-3 text-heading hover:text-blue-900 border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Tiket</a>
                </li>
                <li>
                    <a href="{{ route('about') }}"
                        class="block py-2 px-3 text-heading hover:text-blue-900 border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Tentang</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}"
                        class="block py-2 px-3 text-heading hover:text-blue-900 border-b border-light hover:bg-neutral-secondary-soft md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0">Kontak</a>
                </li>
            </ul>
        </div>

        {{-- Desktop: Auth Buttons --}}
        <div class="hidden md:flex items-center md:order-2 space-x-3 rtl:space-x-reverse">
            @auth
                <button type="button"
                    class="flex text-sm bg-gray-100 rounded-full md:me-0 focus:ring-4 focus:ring-blue-300"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <div
                        class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                </button>
                <div class="z-50 hidden bg-white border border-gray-200 rounded-lg shadow-lg w-48" id="user-dropdown">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <span class="block text-sm font-medium text-gray-800">{{ auth()->user()->name }}</span>
                        <span class="block text-sm text-gray-500 truncate">{{ auth()->user()->email }}</span>
                    </div>
                    <ul class="py-2 text-sm text-gray-700">
                        @if (auth()->user()->is_admin)
                            <li><a href="{{ url('/admin') }}" class="block px-4 py-2 hover:bg-gray-100">Dashboard Admin</a>
                            </li>
                        @endif
                        <li><a href="{{ route('ticket.search') }}" class="block px-4 py-2 hover:bg-gray-100">Cari Tiket
                                Saya</a></li>
                    </ul>
                    <div class="py-2 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center text-gray-700 hover:text-blue-900 font-medium text-sm px-4 py-2 transition-colors">Masuk</a>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center text-white bg-blue-900 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">Daftar</a>
            @endauth
        </div>
    </div>

    {{-- Mobile Navigation Menu (full width, below header) --}}
    <div id="mega-menu-full" class="hidden md:hidden bg-neutral-primary border-t border-default">
        <div class="container mx-auto px-4 py-4">
            <ul class="flex flex-col font-medium space-y-2">
                <li>
                    <a href="{{ route('home') }}"
                        class="block py-3 px-4 text-heading hover:text-blue-900 rounded-lg hover:bg-neutral-secondary-soft"
                        aria-current="page">Beranda</a>
                </li>
                {{-- Mobile Destination Submenu --}}
                <li>
                    <button type="button" id="mobile-destination-btn"
                        class="flex w-full items-center justify-between py-3 px-4 text-heading hover:text-blue-900 rounded-lg hover:bg-neutral-secondary-soft">
                        Destinasi
                        <i id="mobile-angle-icon" class="fa-solid fa-angle-down transition-transform duration-300"></i>
                    </button>
                    <ul id="mobile-destination-menu"
                        class="hidden pl-6 space-y-1 mt-1 bg-neutral-primary-soft rounded-lg">
                        <li><a href="{{ route('destinations.index') }}"
                                class="block py-2 px-4 text-sm text-body hover:text-blue-800">Daftar Destinasi</a></li>
                        <li><a href="{{ route('gallery.index') }}"
                                class="block py-2 px-4 text-sm text-body hover:text-blue-800">Galeri</a></li>
                        <li><a href="{{ route('destinations.islands') }}"
                                class="block py-2 px-4 text-sm text-body hover:text-blue-800">Pulau</a></li>
                        <li><a href="{{ route('destinations.harbors') }}"
                                class="block py-2 px-4 text-sm text-body hover:text-blue-800">Keberangkatan</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('ticket') }}"
                        class="block py-3 px-4 text-heading hover:text-blue-900 rounded-lg hover:bg-neutral-secondary-soft">Tiket</a>
                </li>
                <li>
                    <a href="{{ route('about') }}"
                        class="block py-3 px-4 text-heading hover:text-blue-900 rounded-lg hover:bg-neutral-secondary-soft">Tentang</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}"
                        class="block py-3 px-4 text-heading hover:text-blue-900 rounded-lg hover:bg-neutral-secondary-soft">Kontak</a>
                </li>
                @guest
                    <li class="pt-4 border-t border-default">
                        <a href="{{ route('login') }}"
                            class="block py-3 px-4 text-heading hover:text-blue-900 rounded-lg hover:bg-neutral-secondary-soft">Masuk</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}"
                            class="block py-3 px-4 text-center text-white bg-blue-900 hover:bg-blue-800 rounded-lg font-medium">Daftar</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>

    {{-- Mega Menu Dropdown (Desktop only) --}}
    <div id="mega-menu-full-dropdown" class="mt-1 bg-neutral-primary-soft border-default shadow-xs border-y hidden">
        <div class="flex flex-wrap gap-4 max-w-7xl px-4 py-5 mx-auto text-heading md:px-6">
            <ul aria-labelledby="mega-menu-full-dropdown-button" class="flex flex-row flex-wrap gap-2">
                <li>
                    <a href="{{ route('destinations.index') }}"
                        class="block p-3 rounded-lg hover:bg-neutral-secondary-medium">
                        <div class="font-semibold">Daftar Destinasi</div>
                        <span class="text-sm text-body">Lihat semua destinasi yang tersedia.</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('gallery.index') }}"
                        class="block p-3 rounded-lg hover:bg-neutral-secondary-medium">
                        <div class="font-semibold">Galeri</div>
                        <span class="text-sm text-body">Lihat foto destinasi kami.</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('destinations.islands') }}"
                        class="block p-3 rounded-lg hover:bg-neutral-secondary-medium">
                        <div class="font-semibold">Pulau</div>
                        <span class="text-sm text-body">Rute dan tips pulau populer.</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('destinations.harbors') }}"
                        class="block p-3 rounded-lg hover:bg-neutral-secondary-medium">
                        <div class="font-semibold">Keberangkatan</div>
                        <span class="text-sm text-body">Informasi dan fasilitas keberangkatan.</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mega-menu-full');
            const logo = document.getElementById('navbar-logo');

            if (mobileMenuBtn && mobileMenu && logo) {
                mobileMenuBtn.addEventListener('click', function() {
                    const isHidden = mobileMenu.classList.contains('hidden');
                    if (isHidden) {
                        mobileMenu.classList.remove('hidden');
                        logo.classList.add('hidden');
                        mobileMenuBtn.setAttribute('aria-expanded', 'true');
                    } else {
                        mobileMenu.classList.add('hidden');
                        logo.classList.remove('hidden');
                        mobileMenuBtn.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            // Mobile Destination Toggle
            const mobileDestBtn = document.getElementById('mobile-destination-btn');
            const mobileDestMenu = document.getElementById('mobile-destination-menu');
            const mobileAngleIcon = document.getElementById('mobile-angle-icon');

            if (mobileDestBtn && mobileDestMenu) {
                mobileDestBtn.addEventListener('click', () => {
                    mobileDestMenu.classList.toggle('hidden');
                    mobileAngleIcon.classList.toggle('rotate-180');
                });
            }

            // Desktop mega menu hover
            const btn = document.getElementById('mega-menu-full-dropdown-button');
            const dropdown = document.getElementById('mega-menu-full-dropdown');
            const desktopIcon = document.getElementById('desktop-angle-icon');

            if (!btn || !dropdown) return;

            function isDesktop() {
                return window.matchMedia('(min-width: 768px)').matches;
            }

            let hoverTimeout;

            function open() {
                if (!isDesktop()) return;
                dropdown.classList.remove('hidden');
                btn.setAttribute('aria-expanded', 'true');
                if (desktopIcon) desktopIcon.classList.add('rotate-180');
            }

            function close() {
                if (!isDesktop()) return;
                dropdown.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
                if (desktopIcon) desktopIcon.classList.remove('rotate-180');
            }

            btn.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
                open();
            });
            btn.addEventListener('focus', () => open());

            dropdown.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
                open();
            });
            dropdown.addEventListener('mouseleave', () => {
                hoverTimeout = setTimeout(close, 150);
            });

            const nav = btn.closest('nav');
            if (nav) {
                nav.addEventListener('mouseleave', () => {
                    hoverTimeout = setTimeout(close, 150);
                });
            }

            window.addEventListener('resize', () => {
                if (isDesktop()) {
                    if (logo) logo.classList.remove('hidden');
                    if (mobileMenu) mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
