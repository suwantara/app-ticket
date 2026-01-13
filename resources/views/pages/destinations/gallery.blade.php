<x-layouts.app>
    <x-slot:title>
        @isset($currentDestination)
            Galeri {{ $currentDestination->name }} - Fast Boat Ticket
        @else
            Galeri Destinasi - Fast Boat Ticket
        @endisset
    </x-slot:title>

    <!-- Hero Section -->
    <x-header-section
        title="{{ isset($currentDestination) ? 'Galeri ' . $currentDestination->name : 'Galeri Destinasi' }}"
        subtitle="{{ isset($currentDestination) ? 'Koleksi gambar dari ' . $currentDestination->name : 'Koleksi gambar dari berbagai destinasi wisata' }}" />

    <section class="py-16 bg-neutral-primary">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Filter Section -->
            <div class="mb-10 bg-neutral-primary-soft rounded-xl p-6 border border-default shadow-xs">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-heading mb-3">Filter Destinasi</h2>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('gallery.index') }}"
                                class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ !isset($currentDestination) && !request('destination') ? 'bg-yellow-400 text-black' : 'bg-neutral-secondary-medium border border-default text-body hover:bg-neutral-tertiary-medium' }}">
                                Semua Destinasi
                            </a>
                            @foreach ($destinations as $dest)
                                <a href="{{ route('gallery.show', $dest) }}"
                                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ (isset($currentDestination) && $currentDestination->id == $dest->id) || request('destination') == $dest->id ? 'bg-yellow-400 text-black' : 'bg-neutral-secondary-medium border border-default text-body hover:bg-neutral-tertiary-medium' }}">
                                    {{ $dest->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="text-sm text-body">
                        <span class="font-semibold text-heading">{{ $images->total() }}</span> gambar ditemukan
                    </div>
                </div>
            </div>

            <!-- Masonry Gallery Grid (Unsplash Style) -->
            @if ($images->count() > 0)
                <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 space-y-4">
                    @foreach ($images as $index => $image)
                        <div
                            class="group relative break-inside-avoid overflow-hidden rounded-xl bg-neutral-primary-soft shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer">
                            <!-- Image with natural aspect ratio -->
                            <img src="{{ $image->image_url }}" alt="{{ $image->caption ?? 'Galeri gambar' }}"
                                class="w-full h-auto object-cover group-hover:scale-[1.02] transition-transform duration-500"
                                loading="lazy">

                            <!-- Hover Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">

                                <!-- Top Actions -->
                                <div
                                    class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                                    <button
                                        class="p-2 bg-white/90 hover:bg-white rounded-lg shadow-md transition-colors"
                                        title="Simpan">
                                        <i class="fa-regular fa-bookmark text-gray-700"></i>
                                    </button>
                                    <button
                                        class="p-2 bg-white/90 hover:bg-white rounded-lg shadow-md transition-colors"
                                        title="Bagikan">
                                        <i class="fa-solid fa-arrow-up-from-bracket text-gray-700"></i>
                                    </button>
                                </div>

                                <!-- Bottom Info -->
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    @if ($image->caption)
                                        <p class="text-white text-sm font-medium mb-2 line-clamp-2">
                                            {{ $image->caption }}</p>
                                    @endif

                                    <div class="flex items-center justify-between">
                                        @if ($image->destination)
                                            <a href="{{ route('destinations.show', $image->destination->slug) }}"
                                                class="inline-flex items-center gap-2 text-white hover:text-yellow-400 text-sm font-medium transition-colors">
                                                <div
                                                    class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                                    <i class="fa-solid fa-location-dot text-xs"></i>
                                                </div>
                                                {{ $image->destination->name }}
                                            </a>
                                        @endif

                                        <span
                                            class="text-xs text-gray-300">{{ $image->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Destination Badge (always visible) -->
                            @if ($image->destination)
                                <div
                                    class="absolute top-3 left-3 opacity-100 group-hover:opacity-0 transition-opacity duration-300">
                                    <span
                                        class="px-3 py-1.5 text-xs font-semibold bg-black/50 backdrop-blur-sm text-white rounded-full">
                                        {{ $image->destination->name }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($images->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $images->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-20 bg-neutral-primary-soft rounded-2xl border border-default shadow-xs">
                    <div class="mx-auto w-32 h-32 text-gray-300 mb-8">
                        <i class="fa-regular fa-images text-8xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-heading mb-3">Belum ada gambar galeri</h3>
                    <p class="text-body mb-8 max-w-md mx-auto text-lg">
                        @isset($currentDestination)
                            Destinasi ini belum memiliki gambar galeri.
                        @else
                            Belum ada gambar yang diunggah ke galeri.
                        @endisset
                    </p>
                    <a href="{{ route('destinations.index') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-yellow-400 text-black font-semibold rounded-xl hover:bg-yellow-500 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-compass"></i>
                        Jelajahi Destinasi
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <x-cta-section />
</x-layouts.app>
