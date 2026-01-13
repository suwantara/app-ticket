@props([
    'title' => 'Default Title',
    'subtitle' => null,
])

<!-- Header Section -->
<section class="relative bg-center bg-no-repeat bg-cover min-h-62 flex items-center"
    style="background-image: url({{ asset('img/hero-section.png') }})">
    <!-- Gradient overlay: dark on left, transparent on right -->
    <div class="absolute inset-0 bg-blue-900/70"></div>
    <div class="max-w-7xl mx-auto px-4 text-center z-10">
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">
            {{ $title }}
        </h1>
        <p class="text-lg md:text-xl text-white max-w-2xl mx-auto">
            @if ($subtitle)
                {{ $subtitle }}
            @endif
        </p>
    </div>
</section>
