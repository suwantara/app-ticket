<div>
    {{-- Destinations Preview --}}
    <section class="py-16">
        <div class="container mx-auto px-4">
            {{-- Header with CTA --}}
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-primary mb-4">Destinasi Populer</h2>
                <p class="text-neutral-secondary">Jelajahi keindahan pulau-pulau eksotis di Indonesia</p>
            </div>

            <div class="flex justify-end mb-6">
                {{-- CTA Button --}}
                <a href="{{ route('destinations.index') }}"
                    class="inline-flex items-center gap-2 text-yellow-400 font-semibold hover:text-yellow-500 hover:underline transition-all duration-300">
                    <span>Lihat Destinasi Lainnya</span>
                    <i class="fa-solid fa-arrow-right text-yellow-400"></i>
                </a>
            </div>

            {{-- Responsive Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($destinations as $destination)
                    {{-- Destination Card --}}
                    <div class="bg-neutral-primary-soft p-4 border border-default rounded-base shadow-xs">
                        <a href="{{ route('destinations.show', $destination->slug) }}">
                            <img class="rounded-base w-full h-48 object-cover"
                                src="{{ $destination->image_url ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800' }}"
                                alt="{{ $destination->name }}" />
                        </a>
                        <a href="{{ route('destinations.show', $destination->slug) }}">
                            <h5 class="mt-4 mb-2 text-xl font-semibold tracking-tight text-heading">
                                {{ $destination->name }}
                            </h5>
                        </a>
                        <p class="mb-4 text-body text-sm">{{ Str::limit(strip_tags($destination->description), 120) }}
                        </p>
                        {{-- Action Button --}}
                        <a href="{{ route('destinations.show', $destination->slug) }}"
                            class="block w-full text-center px-6 py-3 bg-yellow-400 text-black text-sm font-semibold rounded-base hover:bg-yellow-500 transition-all duration-300">
                            Lihat Detail
                        </a>
                    </div>
                @empty
                    <p class="text-neutral-secondary col-span-full text-center">Belum ada destinasi tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>
