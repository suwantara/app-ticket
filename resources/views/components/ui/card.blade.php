@props([
    'padding' => true,
    'shadow' => true,
])

@php
    $baseClasses = 'bg-white border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700';
    $paddingClasses = $padding ? 'p-6' : '';
    $shadowClasses = $shadow ? 'shadow-md' : '';
@endphp

<div {{ $attributes->merge(['class' => trim($baseClasses . ' ' . $paddingClasses . ' ' . $shadowClasses)]) }}>
    @if(isset($header))
        <div class="border-b border-gray-200 dark:border-gray-700 -mx-6 -mt-6 px-6 py-4 mb-4 rounded-t-lg bg-gray-50 dark:bg-gray-700">
            {{ $header }}
        </div>
    @endif

    {{ $slot }}

    @if(isset($footer))
        <div class="border-t border-gray-200 dark:border-gray-700 -mx-6 -mb-6 px-6 py-4 mt-4 rounded-b-lg bg-gray-50 dark:bg-gray-700">
            {{ $footer }}
        </div>
    @endif
</div>
