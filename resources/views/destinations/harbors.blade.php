<x-layouts.app>
    <x-slot:title>Pelabuhan Keberangkatan - Fast Boat Ticket</x-slot:title>

    <!-- Hero Section -->
    <x-header-section title="Titik Keberangkatan"
        subtitle="Pilih pelabuhan yang paling nyaman untuk perjalanan fast boat Anda" />

    <!-- Harbors Grid -->
    <section class="py-16 bg-neutral-primary">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Pelabuhan Keberangkatan</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Pelabuhan strategis untuk perjalanan fast boat Anda</p>
            </div>

            @if ($harbors->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($harbors as $destination)
                        <x-destination-card :destination="$destination" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($harbors->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $harbors->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="text-center py-16 bg-neutral-primary-soft rounded-2xl border border-default">
                    <div class="mx-auto w-24 h-24 text-gray-400 mb-6">
                        <i class="fa-solid fa-anchor text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-heading mb-2">Belum ada pelabuhan</h3>
                    <p class="text-body mb-6">Pelabuhan keberangkatan akan segera tersedia.</p>
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
