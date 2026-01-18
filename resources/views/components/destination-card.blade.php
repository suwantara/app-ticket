<div class="bg-neutral-primary-soft p-4 border border-default rounded-base shadow-xs h-full flex flex-col">
    {{-- Image with Tag Overlay --}}
    <div class="relative">
        <a href="{{ route('destinations.show', $destination->slug) }}">
            <img class="rounded-base w-full h-50 object-cover"
                src="{{ $destination->image_url ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800' }}"
                alt="{{ $destination->name }}" />
        </a>
        {{-- Tags --}}
        <div class="absolute top-3 left-3 flex flex-wrap gap-2">
            @if ($destination->is_popular)
                <span
                    class="px-2 py-1 text-xs font-semibold bg-yellow-400 text-yellow-900 rounded-full flex items-center gap-1">
                    <i class="fa-solid fa-star text-xs"></i>
                    Populer
                </span>
            @endif
            @if ($destination->type)
                <span
                    class="px-2 py-1 text-xs font-semibold rounded-full
                    {{ $destination->type === 'island'
                        ? 'bg-green-500 text-white'
                        : ($destination->type === 'harbor'
                            ? 'bg-blue-500 text-white'
                            : 'bg-purple-500 text-white') }}">
                    {{ $destination->type === 'island' ? 'Pulau' : ($destination->type === 'harbor' ? 'Pelabuhan' : 'Kota') }}
                </span>
            @endif
        </div>
    </div>

    {{-- Content --}}
    <a href="{{ route('destinations.show', $destination->slug) }}">
        <h5 class="mt-4 mb-2 text-xl font-semibold tracking-tight text-heading">
            {{ $destination->name }}
        </h5>
    </a>

    {{-- Location --}}
    <div class="flex items-center gap-2 text-sm text-body mb-3">
        <i class="fa-solid fa-location-dot text-gray-400"></i>
        <span>{{ $destination->location ?? 'Indonesia' }}</span>
    </div>

    <p class="mb-4 text-body text-base grow">{{ Str::limit(strip_tags($destination->description), 120) }}</p>

    {{-- Action Button --}}
    <a href="{{ route('destinations.show', $destination->slug) }}"
        class="block w-full text-center px-6 py-3 bg-yellow-400 text-black text-sm font-semibold rounded-base hover:bg-yellow-500 transition-all duration-300">
        Lihat Detail
        <i class="fa-solid fa-arrow-right ms-2"></i>
    </a>
</div>
