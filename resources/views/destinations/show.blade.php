<x-layouts.app>
    <x-slot:title>{{ $destination->name }} - Fast Boat Ticket</x-slot:title>

    <!-- Hero Section -->
    <section class="relative">
        <div class="h-64 md:h-96 overflow-hidden">
            @if($destination->image)
                <img src="{{ Storage::url($destination->image) }}"
                     alt="{{ $destination->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-cyan-300"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12">
            <div class="max-w-screen-xl mx-auto">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                        {{ $destination->type === 'island' ? 'bg-green-500 text-white' :
                           ($destination->type === 'harbor' ? 'bg-blue-500 text-white' : 'bg-purple-500 text-white') }}">
                        {{ $destination->type === 'island' ? 'Pulau' : ($destination->type === 'harbor' ? 'Pelabuhan' : 'Kota') }}
                    </span>
                    @if($destination->is_popular)
                    <span class="px-3 py-1 text-sm font-semibold bg-yellow-400 text-yellow-900 rounded-full flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Populer
                    </span>
                    @endif
                </div>
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-2">
                    {{ $destination->name }}
                </h1>
                <p class="text-lg text-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    </svg>
                    {{ $destination->location }}
                </p>
            </div>
        </div>
    </section>

    <div class="max-w-screen-xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        Tentang {{ $destination->name }}
                    </h2>
                    <div class="prose dark:prose-invert max-w-none">
                        <p class="text-gray-600 dark:text-gray-300">
                            {{ $destination->description }}
                        </p>
                    </div>
                </div>

                <!-- Highlights -->
                @if($destination->highlights && count($destination->highlights) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Highlight
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($destination->highlights as $highlight)
                        <div class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $highlight }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Routes From This Destination -->
                @if($routesFrom->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                        Rute dari {{ $destination->name }}
                    </h2>
                    <div class="space-y-3">
                        @foreach($routesFrom as $route)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 text-xs font-semibold bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded">
                                        {{ $route->code }}
                                    </span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $destination->name }}</span>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                        <a href="{{ route('destinations.show', $route->destination->slug) }}" class="font-medium text-blue-600 hover:underline">
                                            {{ $route->destination->name }}
                                        </a>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $route->distance }} km • {{ $route->formatted_duration }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                    Rp {{ number_format($route->base_price, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">per orang</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Routes To This Destination -->
                @if($routesTo->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                        </svg>
                        Rute ke {{ $destination->name }}
                    </h2>
                    <div class="space-y-3">
                        @foreach($routesTo as $route)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 rounded">
                                        {{ $route->code }}
                                    </span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('destinations.show', $route->origin->slug) }}" class="font-medium text-blue-600 hover:underline">
                                            {{ $route->origin->name }}
                                        </a>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $destination->name }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $route->distance }} km • {{ $route->formatted_duration }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                    Rp {{ number_format($route->base_price, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">per orang</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Info Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        Informasi
                    </h3>

                    <!-- Facilities -->
                    @if($destination->facilities && count($destination->facilities) > 0)
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                            Fasilitas
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($destination->facilities as $facility)
                            <span class="text-sm px-3 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full">
                                {{ $facility }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Location -->
                    @if($destination->latitude && $destination->longitude)
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                            Lokasi
                        </h4>
                        <a href="https://www.google.com/maps?q={{ $destination->latitude }},{{ $destination->longitude }}"
                           target="_blank"
                           class="flex items-center gap-2 text-blue-600 hover:text-blue-700 dark:text-blue-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Lihat di Google Maps
                        </a>
                    </div>
                    @endif

                    <!-- Book Now Button -->
                    <a href="{{ route('home') }}#booking"
                       class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Pesan Tiket
                    </a>
                </div>

                <!-- Related Destinations -->
                @if($relatedDestinations->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        Destinasi Serupa
                    </h3>
                    <div class="space-y-4">
                        @foreach($relatedDestinations as $related)
                        <a href="{{ route('destinations.show', $related->slug) }}"
                           class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                @if($related->image)
                                    <img src="{{ Storage::url($related->image) }}"
                                         alt="{{ $related->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-400 to-cyan-300 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white">
                                    {{ $related->name }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $related->location }}
                                </p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
