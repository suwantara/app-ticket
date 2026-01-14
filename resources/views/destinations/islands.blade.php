<x-layouts.app>
    <x-slot:title>Pulau Wisata - Fast Boat Ticket</x-slot:title>

    <!-- Hero Section -->
    <x-header-section title="Destinasi Pulau"
        subtitle="Jelajahi keindahan pulau-pulau tropis dengan pantai berpasir putih dan air laut jernih" />

    <!-- Islands Grid -->
    <section class="py-16 bg-blue-900">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Pulau Eksotis</h2>
                <p class="text-gray-200 max-w-2xl mx-auto">Temukan keindahan pulau-pulau dengan fast boat terbaik</p>
            </div>

            @if ($islands->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($islands as $destination)
                        <x-destination-card :destination="$destination" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($islands->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $islands->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="text-center py-16 bg-blue-800/50 rounded-2xl">
                    <div class="mx-auto w-24 h-24 text-gray-400 mb-6">
                        <i class="fa-solid fa-island-tropical text-6xl text-white/30"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Belum ada pulau</h3>
                    <p class="text-gray-300 mb-6">Destinasi pulau akan segera tersedia.</p>
                    <a href="{{ route('destinations.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-all duration-300">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali ke Destinasi
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <x-cta-section />
</x-layouts.app>
