<x-layouts.app>
    <x-slot:title>Pulau Wisata - Fast Boat Ticket</x-slot:title>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-green-600 to-emerald-500 py-16 md:py-24">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">
                Pulau Eksotis
            </h1>
            <p class="text-lg md:text-xl text-green-100 max-w-2xl mx-auto">
                Jelajahi keindahan pulau-pulau tropis dengan pantai berpasir putih, air laut jernih, dan pemandangan menakjubkan
            </p>
        </div>
    </section>

    <!-- Islands Grid -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($islands as $island)
                <a href="{{ route('destinations.show', $island->slug) }}"
                   class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative h-56 overflow-hidden">
                        @if($island->image)
                            <img src="{{ Storage::url($island->image) }}"
                                 alt="{{ $island->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-green-400 to-emerald-300 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        @if($island->is_popular)
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-sm font-semibold bg-yellow-400 text-yellow-900 rounded-full flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Populer
                            </span>
                        </div>
                        @endif
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-xl font-bold text-white mb-1">
                                {{ $island->name }}
                            </h3>
                            <p class="text-sm text-gray-200 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                {{ $island->location }}
                            </p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                            {{ $island->short_description ?: Str::limit($island->description, 120) }}
                        </p>

                        @if($island->highlights && count($island->highlights) > 0)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach(array_slice($island->highlights, 0, 3) as $highlight)
                            <span class="text-xs px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full">
                                {{ $highlight }}
                            </span>
                            @endforeach
                            @if(count($island->highlights) > 3)
                            <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-full">
                                +{{ count($island->highlights) - 3 }} lainnya
                            </span>
                            @endif
                        </div>
                        @endif

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $island->routesTo()->where('is_active', true)->count() }} rute tersedia
                            </span>
                            <span class="text-green-600 dark:text-green-400 font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                                Lihat Detail
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Belum ada pulau</h3>
                    <p class="text-gray-500 dark:text-gray-400">Destinasi pulau akan segera tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-green-600 to-emerald-500">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
                Siap Berlibur ke Pulau Impian?
            </h2>
            <p class="text-green-100 mb-8 max-w-xl mx-auto">
                Pesan tiket fast boat sekarang dan mulai petualangan Anda ke pulau-pulau eksotis.
            </p>
            <a href="{{ route('home') }}#booking"
               class="inline-flex items-center gap-2 px-8 py-3 bg-white text-green-600 font-semibold rounded-lg hover:bg-green-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                Pesan Tiket Sekarang
            </a>
        </div>
    </section>
</x-layouts.app>
