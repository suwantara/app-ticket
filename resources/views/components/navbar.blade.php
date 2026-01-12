

<nav class="bg-white shadow-lg fixed w-full z-50 top-0 start-0 border-b border-gray-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <i class="fa-solid fa-ship text-2xl text-blue-600"></i>
            <span class="self-center text-xl font-bold whitespace-nowrap text-gray-800">Fast<span class="text-blue-600">Boat</span>Ticket</span>
        </a>

        {{-- Mobile Menu Button & User Menu --}}
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            {{-- Login/Register or User Menu --}}
            @auth
                <button type="button" class="flex text-sm bg-gray-100 rounded-full md:me-0 focus:ring-4 focus:ring-blue-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </button>
                <!-- Dropdown menu -->
                <div class="z-50 hidden bg-white border border-gray-200 rounded-lg shadow-lg w-48" id="user-dropdown">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <span class="block text-sm font-medium text-gray-800">{{ auth()->user()->name }}</span>
                        <span class="block text-sm text-gray-500 truncate">{{ auth()->user()->email }}</span>
                    </div>
                    <ul class="py-2 text-sm text-gray-700">
                        <li>
                            <a href="{{ url('/admin') }}" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fa-solid fa-gauge-high mr-2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fa-solid fa-ticket mr-2"></i> Pesanan Saya
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                                <i class="fa-solid fa-user mr-2"></i> Profil
                            </a>
                        </li>
                    </ul>
                    <div class="py-2 border-t border-gray-200">
                        <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('filament.admin.auth.login') }}" class="hidden md:inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Login
                </a>
            @endauth

            {{-- Mobile Menu Toggle --}}
            <button data-collapse-toggle="navbar-menu" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-menu" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>

        {{-- Navigation Menu --}}
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-menu">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                {{-- Dynamic Pages from CMS --}}
                @foreach($navbarPages as $navPage)
                    @php
                        // Determine route based on slug
                        $route = match($navPage->slug) {
                            'home' => route('home'),
                            'about' => route('about'),
                            'contact' => route('contact'),
                            default => route('page.show', $navPage->slug)
                        };

                        // Check if current page is active
                        $isActive = request()->is('/') && $navPage->slug === 'home' ||
                                   request()->is($navPage->slug) ||
                                   request()->is('page/' . $navPage->slug);
                    @endphp
                    <li>
                        <a href="{{ $route }}"
                           class="block py-2 px-3 rounded md:p-0 transition-colors cursor-pointer
                                  {{ $isActive
                                     ? 'text-blue-600 font-semibold md:bg-transparent'
                                     : 'text-gray-700 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-600' }}">
                            {{ $navPage->title }}
                        </a>
                    </li>
                @endforeach

                {{-- Pesan Tiket Link --}}
                <li>
                    <a href="{{ route('ticket') }}"
                       class="block py-2 px-3 rounded md:p-0 transition-colors cursor-pointer
                              {{ request()->is('ticket') ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-600' }}">
                        <i class="fa-solid fa-ticket mr-1"></i> Pesan Tiket
                    </a>
                </li>

                {{-- Destinations Dropdown --}}
                <li class="relative group">
                    <button type="button"
                            class="flex items-center gap-1 py-2 px-3 rounded md:p-0 transition-colors text-gray-700 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-600 {{ request()->is('destinations*') ? 'text-blue-600 font-semibold' : '' }}"
                            data-dropdown-toggle="destinations-dropdown">
                        Destinasi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="destinations-dropdown" class="z-50 hidden md:group-hover:block md:absolute md:top-full md:left-0 md:pt-2">
                        <ul class="bg-white border border-gray-200 rounded-lg shadow-lg py-2 w-48">
                            <li>
                                <a href="{{ route('destinations.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fa-solid fa-globe mr-2 text-blue-500"></i> Semua Destinasi
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('destinations.islands') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fa-solid fa-umbrella-beach mr-2 text-green-500"></i> Pulau
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('destinations.harbors') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fa-solid fa-anchor mr-2 text-blue-500"></i> Pelabuhan
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Mobile Login Button --}}
                @guest
                    <li class="md:hidden">
                        <a href="{{ route('filament.admin.auth.login') }}" class="block py-2 px-3 text-blue-600 font-medium rounded hover:bg-gray-100">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i> Login
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
