@props([
    'icon',
    'iconBg' => 'blue', // blue, green, yellow, purple, red, gray
    'label',
])

@php
    $bgClasses = match($iconBg) {
        'green' => 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400',
        'yellow' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400',
        'purple' => 'bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400',
        'red' => 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400',
        'gray' => 'bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400',
        default => 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400',
    };
@endphp

<div class="flex items-center gap-4">
    <div class="flex-shrink-0">
        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $bgClasses }}">
            {!! $icon !!}
        </div>
    </div>
    <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
        <div>{{ $slot }}</div>
    </div>
</div>
