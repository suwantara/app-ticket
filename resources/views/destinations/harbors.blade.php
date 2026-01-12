<x-layouts.app>
    <x-slot:title>Pelabuhan Keberangkatan - Fast Boat Ticket</x-slot:title>

    <!-- Hero Section -->
    <section class="bg-linear-to-r from-teal-500 to-purple-600 py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <svg class="w-10 h-10 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">
                Pelabuhan Keberangkatan
            </h1>
            <p class="text-lg md:text-xl text-teal-100 max-w-2xl mx-auto">
                Pilih titik keberangkatan yang paling nyaman untuk perjalanan fast boat Anda
            </p>
        </div>
    </section>

    <!-- Harbors Grid -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($harbors as $harbor)
                <a href="{{ route('destinations.show', $harbor->slug) }}"
                   class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="md:flex">
                        <div class="md:w-2/5 relative h-48 md:h-auto overflow-hidden">
                            @if($harbor->image)
                                <img src="{{ Storage::url($harbor->image) }}"
                                     alt="{{ $harbor->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-linear-to-br from-teal-400 to-purple-300 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            @endif
                            @if($harbor->is_popular)
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 text-sm font-semibold bg-yellow-400 text-yellow-900 rounded-full flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    Populer
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="md:w-3/5 p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-teal-600 transition-colors">
                                        {{ $harbor->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        {{ $harbor->location }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 rounded-full">
                                    Pelabuhan
                                </span>
                            </div>

                            <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                                {{ $harbor->short_description ?: Str::limit($harbor->description, 100) }}
                            </p>

                            @if($harbor->facilities && count($harbor->facilities) > 0)
                            <div class="mb-4">
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Fasilitas</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(array_slice($harbor->facilities, 0, 4) as $facility)
                                    <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded">
                                        {{ $facility }}
                                    </span>
                                    @endforeach
                                    @if(count($harbor->facilities) > 4)
                                    <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded">
                                        +{{ count($harbor->facilities) - 4 }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $harbor->routesFrom()->where('is_active', true)->count() }} rute keberangkatan
                                </span>
                                <span class="text-teal-600 dark:text-teal-400 font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                                    Lihat Rute
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Belum ada pelabuhan</h3>
                    <p class="text-gray-500 dark:text-gray-400">Pelabuhan keberangkatan akan segera tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Info Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Lokasi Strategis</h3>
                    <p class="text-gray-600 dark:text-gray-300">Pelabuhan kami terletak di lokasi strategis dengan akses mudah dari berbagai area.</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Fasilitas Lengkap</h3>
                    <p class="text-gray-600 dark:text-gray-300">Tersedia parkir, ruang tunggu nyaman, toilet, dan berbagai fasilitas penunjang lainnya.</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Jadwal Tepat Waktu</h3>
                    <p class="text-gray-600 dark:text-gray-300">Fast boat kami beroperasi tepat waktu dengan jadwal keberangkatan yang teratur.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-linear-to-r from-teal-500 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">
                Pilih Pelabuhan & Mulai Perjalanan
            </h2>
            <p class="text-teal-100 mb-8 max-w-xl mx-auto">
                Booking tiket fast boat dari pelabuhan pilihan Anda dan nikmati perjalanan yang nyaman.
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
