@props([
    'type' => 'button', // button, submit, reset
    'color' => 'primary', // primary, secondary, success, danger, warning, info, light, dark
    'size' => 'default', // xs, sm, default, lg, xl
    'outline' => false,
    'pill' => false,
    'loading' => false,
    'disabled' => false,
    'href' => null,
    'icon' => null,
    'iconPosition' => 'left',
])

@php
    $tag = $href ? 'a' : 'button';

    $baseClasses = 'inline-flex items-center justify-center font-medium focus:outline-none focus:ring-4 transition-colors duration-200';

    $sizeClasses = match($size) {
        'xs' => 'px-3 py-2 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'lg' => 'px-5 py-3 text-base',
        'xl' => 'px-6 py-3.5 text-base',
        default => 'px-5 py-2.5 text-sm',
    };

    $roundedClasses = $pill ? 'rounded-full' : 'rounded-lg';

    $colorClasses = match($color) {
        'secondary' => $outline
            ? 'text-gray-900 bg-transparent border border-gray-800 hover:bg-gray-900 hover:text-white focus:ring-gray-300 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600'
            : 'text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-gray-100 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700',
        'success' => $outline
            ? 'text-green-700 bg-transparent border border-green-700 hover:bg-green-800 hover:text-white focus:ring-green-300 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600'
            : 'text-white bg-green-700 hover:bg-green-800 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
        'danger' => $outline
            ? 'text-red-700 bg-transparent border border-red-700 hover:bg-red-800 hover:text-white focus:ring-red-300 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600'
            : 'text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900',
        'warning' => $outline
            ? 'text-yellow-400 bg-transparent border border-yellow-400 hover:bg-yellow-500 hover:text-white focus:ring-yellow-300 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400'
            : 'text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-yellow-300 dark:focus:ring-yellow-900',
        'info' => $outline
            ? 'text-blue-700 bg-transparent border border-blue-700 hover:bg-blue-800 hover:text-white focus:ring-blue-300 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500'
            : 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800',
        'light' => 'text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-gray-100 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700',
        'dark' => $outline
            ? 'text-gray-900 bg-transparent border border-gray-800 hover:bg-gray-900 hover:text-white focus:ring-gray-300 dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600'
            : 'text-white bg-gray-800 hover:bg-gray-900 focus:ring-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700',
        default => $outline
            ? 'text-blue-700 bg-transparent border border-blue-700 hover:bg-blue-800 hover:text-white focus:ring-blue-300 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500'
            : 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800',
    };

    $disabledClasses = ($disabled || $loading) ? 'opacity-50 cursor-not-allowed' : '';
@endphp

<{{ $tag }}
    {{ $attributes->merge(['class' => trim($baseClasses . ' ' . $sizeClasses . ' ' . $roundedClasses . ' ' . $colorClasses . ' ' . $disabledClasses)]) }}
    @if($tag === 'button') type="{{ $type }}" @endif
    @if($href) href="{{ $href }}" @endif
    @if($disabled || $loading) disabled @endif
    @if($loading) wire:loading.attr="disabled" @endif
>
    @if($loading)
        <svg class="w-4 h-4 me-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($icon && $iconPosition === 'left')
        <span class="me-2">{!! $icon !!}</span>
    @endif

    {{ $slot }}

    @if($icon && $iconPosition === 'right' && !$loading)
        <span class="ms-2">{!! $icon !!}</span>
    @endif
</{{ $tag }}>
