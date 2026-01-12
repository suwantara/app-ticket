<x-layouts.app>
    <x-slot:title>
        @isset($currentDestination)
            Galeri {{ $currentDestination->name }} - Fast Boat Ticket
        @else
            Galeri Destinasi - Fast Boat Ticket
        @endisset
    </x-slot:title>

    <div class="container mx-auto px-4 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                @isset($currentDestination)
                    Galeri {{ $currentDestination->name }}
                @else
                    Galeri Destinasi
                @endisset
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                @isset($currentDestination)
                    Koleksi gambar dari {{ $currentDestination->name }}
                @else
                    Koleksi gambar dari berbagai destinasi wisata
                @endisset
            </p>
        </div>

        <!-- Filter Section -->
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Filter Destinasi</h2>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('gallery.index') }}"
                           class="px-4 py-2 rounded-full {{ !isset($currentDestination) && !request('destination') ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            Semua Destinasi
                        </a>
                        @foreach($destinations as $dest)
                        <a href="{{ route('gallery.show', $dest) }}"
                           class="px-4 py-2 rounded-full {{ (isset($currentDestination) && $currentDestination->id == $dest->id) || request('destination') == $dest->id ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            {{ $dest->name }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $images->count() }}</span> gambar ditemukan
                </div>
            </div>
        </div>

        <!-- Gallery Grid -->
        @if($images->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($images as $image)
            <div class="group relative overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-sm hover:shadow-md transition-shadow duration-300">
                <!-- Image -->
                <div class="aspect-square overflow-hidden">
                    <img src="{{ $image->image_url }}"
                         alt="{{ $image->caption ?? 'Galeri gambar' }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>

                <!-- Overlay Content -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                    @if($image->caption)
                    <p class="text-white text-sm mb-2 line-clamp-2">{{ $image->caption }}</p>
                    @endif

                    @if($image->destination)
                    <div class="flex items-center justify-between">
                        <a href="{{ route('destinations.show', $image->destination->slug) }}"
                           class="inline-flex items-center gap-1 text-blue-300 hover:text-white text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            {{ $image->destination->name }}
                        </a>
                        <span class="text-xs text-gray-300">{{ $image->created_at->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>

                <!-- Badge for destination -->
                @if($image->destination)
                <div class="absolute top-3 left-3">
                    <span class="px-2 py-1 text-xs font-medium bg-black/50 text-white rounded-full backdrop-blur-sm">
                        {{ $image->destination->name }}
                    </span>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($images->hasPages())
        <div class="mt-8">
            {{ $images->links() }}
        </div>
        @endif
        @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
            <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum ada gambar galeri</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                @isset($currentDestination)
                    Destinasi ini belum memiliki gambar galeri.
                @else
                    Belum ada gambar yang diunggah ke galeri.
                @endif
            </p>
            <a href="{{ route('destinations.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                </svg>
                Jelajahi Destinasi
            </a>
        </div>
        @endif
    </div>
</x-layouts.app>
