<x-layouts.app>
    <x-slot:title>{{ $destination->name }} - Fast Boat Ticket</x-slot:title>

    <!-- Hero Section - Full Width -->
    <section class="relative h-[50vh] md:h-[60vh] overflow-hidden">
        @if ($destination->image)
            <img src="{{ Storage::url($destination->image) }}" alt="{{ $destination->name }}"
                class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-linear-to-br from-blue-600 to-blue-900"></div>
        @endif
        <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/40 to-transparent"></div>

        <!-- Hero Content -->
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12">
            <div class="max-w-4xl mx-auto">
                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-2 text-sm text-gray-300 mb-4">
                    <a href="{{ route('destinations.index') }}" class="hover:text-white transition-colors">Destinasi</a>
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                    <span class="text-white">{{ $destination->name }}</span>
                </nav>

                {{-- Tags --}}
                <div class="flex items-center gap-3 mb-4">
                    <span
                        class="px-3 py-1 text-sm font-semibold rounded-full {{ $destination->type === 'island' ? 'bg-green-500 text-white' : ($destination->type === 'harbor' ? 'bg-blue-500 text-white' : 'bg-purple-500 text-white') }}">
                        {{ $destination->type === 'island' ? 'Pulau' : ($destination->type === 'harbor' ? 'Pelabuhan' : 'Kota') }}
                    </span>
                    @if ($destination->is_popular)
                        <span
                            class="px-3 py-1 text-sm font-semibold bg-yellow-400 text-yellow-900 rounded-full flex items-center gap-1">
                            <i class="fa-solid fa-star text-xs"></i>
                            Populer
                        </span>
                    @endif
                </div>

                {{-- Title --}}
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-3">
                    {{ $destination->name }}
                </h1>

                {{-- Meta --}}
                <div class="flex items-center gap-6 text-gray-200">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $destination->location }}
                    </span>
                    @if ($routesFrom->count() > 0 || $routesTo->count() > 0)
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-route"></i>
                            {{ $routesFrom->count() + $routesTo->count() }} rute tersedia
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content - Blog Style -->
    <section class="py-12 bg-neutral-primary">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- Article Content -->
                <article class="lg:col-span-8 space-y-8">

                    <!-- Description Card -->
                    <div class="bg-neutral-primary-soft rounded-2xl p-8 border border-default shadow-sm">
                        <h2 class="text-2xl font-bold text-heading mb-6 flex items-center gap-3">
                            <i class="fa-solid fa-info-circle text-blue-500"></i>
                            Tentang {{ $destination->name }}
                        </h2>
                        <div class="prose prose-lg max-w-none text-body leading-relaxed">
                            {!! nl2br(e($destination->description)) !!}
                        </div>
                    </div>

                    <!-- Highlights -->
                    @if ($destination->highlights && count($destination->highlights) > 0)
                        <div class="bg-neutral-primary-soft rounded-2xl p-8 border border-default shadow-sm">
                            <h2 class="text-2xl font-bold text-heading mb-6 flex items-center gap-3">
                                <i class="fa-solid fa-star text-yellow-500"></i>
                                Highlight
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($destination->highlights as $highlight)
                                    <div
                                        class="flex items-center gap-3 p-4 bg-green-50 rounded-xl border border-green-100">
                                        <div
                                            class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-check text-white text-sm"></i>
                                        </div>
                                        <span class="text-gray-700 font-medium">{{ $highlight }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Gallery Section -->
                    @if ($galleryImages->count() > 0)
                        <div class="bg-neutral-primary-soft rounded-2xl p-8 border border-default shadow-sm">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-heading flex items-center gap-3">
                                    <i class="fa-solid fa-images text-purple-500"></i>
                                    Galeri Foto
                                </h2>
                                <a href="{{ route('gallery.show', $destination) }}"
                                    class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                                    Lihat Semua
                                    <i class="fa-solid fa-arrow-right text-sm"></i>
                                </a>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach ($galleryImages->take(8) as $image)
                                    <div class="aspect-square rounded-xl overflow-hidden">
                                        <img src="{{ $image->image_url }}"
                                            alt="{{ $image->caption ?? $destination->name }}"
                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Routes From -->
                    @if ($routesFrom->count() > 0)
                        <div class="bg-neutral-primary-soft rounded-2xl p-8 border border-default shadow-sm">
                            <h2 class="text-2xl font-bold text-heading mb-6 flex items-center gap-3">
                                <i class="fa-solid fa-plane-departure text-blue-500"></i>
                                Rute dari {{ $destination->name }}
                            </h2>
                            <div class="space-y-4">
                                @foreach ($routesFrom as $route)
                                    <div
                                        class="flex items-center justify-between p-5 bg-white rounded-xl border border-gray-100 hover:border-blue-200 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                                <i class="fa-solid fa-ship text-blue-600"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span
                                                        class="font-bold text-heading">{{ $destination->name }}</span>
                                                    <i class="fa-solid fa-arrow-right text-gray-400 text-sm"></i>
                                                    <a href="{{ route('destinations.show', $route->destination->slug) }}"
                                                        class="font-bold text-blue-600 hover:underline">
                                                        {{ $route->destination->name }}
                                                    </a>
                                                </div>
                                                <div class="flex items-center gap-4 text-sm text-body">
                                                    <span><i
                                                            class="fa-regular fa-clock mr-1"></i>{{ $route->formatted_duration }}</span>
                                                    <span><i class="fa-solid fa-ruler mr-1"></i>{{ $route->distance }}
                                                        km</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-heading">Rp
                                                {{ number_format($route->base_price, 0, ',', '.') }}</p>
                                            <p class="text-sm text-body">per orang</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Routes To -->
                    @if ($routesTo->count() > 0)
                        <div class="bg-neutral-primary-soft rounded-2xl p-8 border border-default shadow-sm">
                            <h2 class="text-2xl font-bold text-heading mb-6 flex items-center gap-3">
                                <i class="fa-solid fa-plane-arrival text-green-500"></i>
                                Rute ke {{ $destination->name }}
                            </h2>
                            <div class="space-y-4">
                                @foreach ($routesTo as $route)
                                    <div
                                        class="flex items-center justify-between p-5 bg-white rounded-xl border border-gray-100 hover:border-green-200 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                                <i class="fa-solid fa-ship text-green-600"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2 mb-1">
                                                    <a href="{{ route('destinations.show', $route->origin->slug) }}"
                                                        class="font-bold text-green-600 hover:underline">
                                                        {{ $route->origin->name }}
                                                    </a>
                                                    <i class="fa-solid fa-arrow-right text-gray-400 text-sm"></i>
                                                    <span
                                                        class="font-bold text-heading">{{ $destination->name }}</span>
                                                </div>
                                                <div class="flex items-center gap-4 text-sm text-body">
                                                    <span><i
                                                            class="fa-regular fa-clock mr-1"></i>{{ $route->formatted_duration }}</span>
                                                    <span><i class="fa-solid fa-ruler mr-1"></i>{{ $route->distance }}
                                                        km</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-heading">Rp
                                                {{ number_format($route->base_price, 0, ',', '.') }}</p>
                                            <p class="text-sm text-body">per orang</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </article>

                <!-- Sidebar - Sticky -->
                <aside class="lg:col-span-4">
                    <div class="sticky top-24 space-y-6">

                        <!-- Quick Booking Card -->
                        <div class="bg-blue-900 rounded-2xl p-6 text-white shadow-xl">
                            <h3 class="text-xl font-bold mb-4">Pesan Tiket Sekarang</h3>
                            <p class="text-blue-200 mb-6 text-sm">Dapatkan tiket fast boat dengan harga terbaik ke
                                {{ $destination->name }}</p>
                            <a href="{{ route('ticket') }}"
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-500 transition-all duration-300 shadow-lg">
                                <i class="fa-solid fa-ticket"></i>
                                Pesan Sekarang
                            </a>
                        </div>

                        <!-- Info Card -->
                        <div class="bg-neutral-primary-soft rounded-2xl p-6 border border-default shadow-sm">
                            <h3 class="text-lg font-bold text-heading mb-4">Informasi</h3>

                            {{-- Location --}}
                            <div class="flex items-start gap-3 mb-4 pb-4 border-b border-default">
                                <div
                                    class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-location-dot text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-body">Lokasi</p>
                                    <p class="font-medium text-heading">{{ $destination->location }}</p>
                                </div>
                            </div>

                            {{-- Type --}}
                            <div class="flex items-start gap-3 mb-4 pb-4 border-b border-default">
                                <div
                                    class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-tag text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-body">Tipe</p>
                                    <p class="font-medium text-heading">
                                        {{ $destination->type === 'island' ? 'Pulau' : ($destination->type === 'harbor' ? 'Pelabuhan' : 'Kota') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Google Maps --}}
                            @if ($destination->latitude && $destination->longitude)
                                <a href="https://www.google.com/maps?q={{ $destination->latitude }},{{ $destination->longitude }}"
                                    target="_blank"
                                    class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                    <div
                                        class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-map text-red-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-heading">Lihat di Google Maps</p>
                                        <p class="text-sm text-body">Buka lokasi di peta</p>
                                    </div>
                                    <i class="fa-solid fa-external-link text-gray-400 ml-auto"></i>
                                </a>
                            @endif
                        </div>

                        <!-- Facilities -->
                        @if ($destination->facilities && count($destination->facilities) > 0)
                            <div class="bg-neutral-primary-soft rounded-2xl p-6 border border-default shadow-sm">
                                <h3 class="text-lg font-bold text-heading mb-4">Fasilitas</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($destination->facilities as $facility)
                                        <span
                                            class="text-sm px-3 py-2 bg-blue-50 text-blue-700 rounded-lg font-medium">
                                            {{ $facility }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Related Destinations -->
                        @if ($relatedDestinations->count() > 0)
                            <div class="bg-neutral-primary-soft rounded-2xl p-6 border border-default shadow-sm">
                                <h3 class="text-lg font-bold text-heading mb-4">Destinasi Serupa</h3>
                                <div class="space-y-4">
                                    @foreach ($relatedDestinations as $related)
                                        <a href="{{ route('destinations.show', $related->slug) }}"
                                            class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                            <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                                                @if ($related->image)
                                                    <img src="{{ Storage::url($related->image) }}"
                                                        alt="{{ $related->name }}"
                                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                @else
                                                    <div
                                                        class="w-full h-full bg-linear-to-br from-blue-400 to-cyan-300 flex items-center justify-center">
                                                        <i class="fa-solid fa-location-dot text-white/50"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4
                                                    class="font-semibold text-heading truncate group-hover:text-blue-600 transition-colors">
                                                    {{ $related->name }}
                                                </h4>
                                                <p class="text-sm text-body truncate">
                                                    {{ $related->location }}
                                                </p>
                                            </div>
                                            <i
                                                class="fa-solid fa-chevron-right text-gray-300 group-hover:text-blue-500 transition-colors"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <x-cta-section />
</x-layouts.app>
