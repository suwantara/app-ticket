<x-layouts.app>
    <x-slot:title>Destinasi - Fast Boat Ticket</x-slot:title>

    <!-- Hero Section -->
    <x-header-section title="Destinasi" subtitle="Jelajahi Destinasi Wisata" />

    <!-- Popular Destinations -->
    @if ($popularDestinations->count() > 0)
        <section class="py-16 bg-neutral-primary">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <span class="text-teal-600 font-semibold text-sm uppercase tracking-wider">
                        Paling Diminati
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">
                        Destinasi Populer
                    </h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($popularDestinations->take(6) as $destination)
                        <x-destination-card :destination="$destination" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Islands Section -->
    @if (isset($destinations['island']) && $destinations['island']->count() > 0)
        <section class="py-16 bg-blue-900">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Destinasi Pulau</h2>
                    <p class="text-gray-200 max-w-2xl mx-auto">Jelajahi pulau-pulau eksotis dengan fast boat terbaik</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($destinations['island']->take(4) as $destination)
                        <x-destination-card :destination="$destination" />
                    @endforeach
                </div>

                {{-- View All Button --}}
                @if ($destinations['island']->count() > 4)
                    <div class="text-center mt-10">
                        <a href="{{ route('destinations.islands') }}"
                            class="inline-flex items-center gap-2 px-8 py-3 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-all duration-300">
                            Lihat Semua Pulau
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Harbors Section -->
    @if (isset($destinations['harbor']) && $destinations['harbor']->count() > 0)
        <section class="py-16 bg-neutral-primary">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Titik Keberangkatan</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Pelabuhan strategis untuk perjalanan fast boat Anda</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($destinations['harbor']->take(4) as $destination)
                        <x-destination-card :destination="$destination" />
                    @endforeach
                </div>

                {{-- View All Button --}}
                @if ($destinations['harbor']->count() > 4)
                    <div class="text-center mt-10">
                        <a href="{{ route('destinations.harbors') }}"
                            class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-300">
                            Lihat Semua Pelabuhan
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- CTA Section -->
    <x-cta-section />
</x-layouts.app>
