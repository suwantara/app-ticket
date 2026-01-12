<x-layouts.app>
    <x-slot:title>Destinasi - Fast Boat Ticket</x-slot:title>

    <!-- Hero Section -->
    <section class="bg-linear-to-r from-teal-500 to-purple-600 py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">
                Jelajahi Destinasi Wisata
            </h1>
            <p class="text-lg md:text-xl text-teal-100 max-w-2xl mx-auto">
                Temukan keindahan pulau-pulau eksotis dan pelabuhan strategis untuk perjalanan fast boat Anda
            </p>
        </div>
    </section>

    <!-- Popular Destinations -->
    @if($popularDestinations->count() > 0)
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-teal-600 dark:text-teal-400 font-semibold text-sm uppercase tracking-wider">
                    Paling Diminati
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mt-2">
                    Destinasi Populer
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($popularDestinations as $destination)
                <a href="{{ route('destinations.show', $destination->slug) }}"
                   class="group block bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative h-48 overflow-hidden">
                        @if($destination->image)
                            <img src="{{ Storage::url($destination->image) }}"
                                 alt="{{ $destination->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-linear-to-br from-teal-400 to-purple-300 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $destination->type === 'island' ? 'bg-green-500 text-white' :
                                   ($destination->type === 'harbor' ? 'bg-blue-500 text-white' : 'bg-purple-500 text-white') }}">
                                {{ $destination->type === 'island' ? 'Pulau' : ($destination->type === 'harbor' ? 'Pelabuhan' : 'Kota') }}
                            </span>
                        </div>
                        @if($destination->is_popular)
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 text-xs font-semibold bg-yellow-400 text-yellow-900 rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Populer
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-teal-600 transition-colors">
                            {{ $destination->name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            {{ $destination->location }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-3 line-clamp-2">
                            {{ $destination->short_description }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Islands Section -->
    @if(isset($destinations['island']) && $destinations['island']->count() > 0)
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span class="text-green-600 dark:text-green-400 font-semibold text-sm uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pulau Eksotis
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mt-2">
                        Destinasi Pulau
                    </h2>
                </div>
                     <a href="{{ route('destinations.islands') }}"
                         class="text-teal-600 hover:text-teal-700 dark:text-teal-400 font-medium flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($destinations['island']->take(4) as $island)
                <a href="{{ route('destinations.show', $island->slug) }}"
                   class="group block bg-gray-50 dark:bg-gray-700 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300">
                    <div class="relative h-40 overflow-hidden">
                        @if($island->image)
                            <img src="{{ Storage::url($island->image) }}"
                                 alt="{{ $island->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-linear-to-br from-green-400 to-emerald-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-green-600 transition-colors">
                            {{ $island->name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ $island->location }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Harbors Section -->
    @if(isset($destinations['harbor']) && $destinations['harbor']->count() > 0)
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span class="text-blue-600 dark:text-blue-400 font-semibold text-sm uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Pelabuhan Keberangkatan
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mt-2">
                        Titik Keberangkatan
                    </h2>
                </div>
                     <a href="{{ route('destinations.harbors') }}"
                         class="text-teal-600 hover:text-teal-700 dark:text-teal-400 font-medium flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($destinations['harbor'] as $harbor)
                <a href="{{ route('destinations.show', $harbor->slug) }}"
                   class="group block bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 hover:border-blue-500 hover:shadow-lg transition-all duration-300">
                    <div class="p-5">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4 group-hover:bg-blue-500 transition-colors">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">
                            {{ $harbor->name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            {{ $harbor->location }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-3 line-clamp-2">
                            {{ $harbor->short_description }}
                        </p>
                        @if($harbor->facilities)
                        <div class="flex flex-wrap gap-1 mt-3">
                            @foreach(array_slice($harbor->facilities, 0, 3) as $facility)
                            <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded">
                                {{ $facility }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-16 bg-linear-to-r from-teal-500 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
                Siap Menjelajah?
            </h2>
            <p class="text-teal-100 mb-8 max-w-xl mx-auto">
                Pesan tiket fast boat sekarang dan nikmati perjalanan ke destinasi impian Anda dengan harga terbaik.
            </p>
            <a href="{{ route('home') }}#booking"
               class="inline-flex items-center gap-2 px-8 py-3 bg-white text-teal-600 font-semibold rounded-lg hover:bg-teal-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                Pesan Tiket Sekarang
            </a>
        </div>
    </section>
</x-layouts.app>
