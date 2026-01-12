<div class="bg-neutral-primary-soft block max-w-sm p-6 border border-default rounded-base shadow-xs">
    <a href="{{ route('destinations.show', $destination->slug) }}">
        @if($destination->image)
            <img class="rounded-base w-full h-48 object-cover" src="{{ Storage::url($destination->image) }}" alt="{{ $destination->name }}" />
        @else
            <div class="w-full h-48 rounded-base bg-gray-200 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a4 4 0 014-4h10a4 4 0 014 4v10a4 4 0 01-4 4H7a4 4 0 01-4-4V7z" />
                </svg>
            </div>
        @endif
    </a>
    <a href="{{ route('destinations.show', $destination->slug) }}">
        <h5 class="mt-6 mb-2 text-2xl font-semibold tracking-tight text-heading">{{ $destination->name }}</h5>
    </a>
    <p class="mb-4 text-sm text-body">{{ $destination->short_description ?? Str::limit($destination->description ?? '', 120) }}</p>
    <div class="flex items-center justify-between">
        <div class="text-sm text-body">{{ $destination->location }}</div>
        <a href="{{ route('destinations.show', $destination->slug) }}" class="inline-flex items-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
            Lihat
            <svg class="w-4 h-4 ms-1.5 rtl:rotate-180 -me-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/></svg>
        </a>
    </div>
</div>
