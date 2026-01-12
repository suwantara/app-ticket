@props([
    'color' => 'blue', // blue, gray, red, green, yellow, indigo, purple, pink
    'size' => 'default', // default, large
    'border' => false,
    'pill' => false,
])

@php
    $baseClasses = 'font-medium me-2';

    $sizeClasses = match($size) {
        'large' => 'text-sm px-2.5 py-0.5',
        default => 'text-xs px-2.5 py-0.5',
    };

    $roundedClasses = $pill ? 'rounded-full' : 'rounded';

    $colorClasses = match($color) {
        'gray' => $border
            ? 'bg-gray-100 text-gray-800 border border-gray-500 dark:bg-gray-700 dark:text-gray-400'
            : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'red' => $border
            ? 'bg-red-100 text-red-800 border border-red-400 dark:bg-gray-700 dark:text-red-400'
            : 'bg-red-100 text-red-800 dark:bg-gray-700 dark:text-red-400',
        'green' => $border
            ? 'bg-green-100 text-green-800 border border-green-400 dark:bg-gray-700 dark:text-green-400'
            : 'bg-green-100 text-green-800 dark:bg-gray-700 dark:text-green-400',
        'yellow' => $border
            ? 'bg-yellow-100 text-yellow-800 border border-yellow-300 dark:bg-gray-700 dark:text-yellow-300'
            : 'bg-yellow-100 text-yellow-800 dark:bg-gray-700 dark:text-yellow-300',
        'indigo' => $border
            ? 'bg-indigo-100 text-indigo-800 border border-indigo-400 dark:bg-gray-700 dark:text-indigo-400'
            : 'bg-indigo-100 text-indigo-800 dark:bg-gray-700 dark:text-indigo-400',
        'purple' => $border
            ? 'bg-purple-100 text-purple-800 border border-purple-400 dark:bg-gray-700 dark:text-purple-400'
            : 'bg-purple-100 text-purple-800 dark:bg-gray-700 dark:text-purple-400',
        'pink' => $border
            ? 'bg-pink-100 text-pink-800 border border-pink-400 dark:bg-gray-700 dark:text-pink-400'
            : 'bg-pink-100 text-pink-800 dark:bg-gray-700 dark:text-pink-400',
        default => $border
            ? 'bg-blue-100 text-blue-800 border border-blue-400 dark:bg-gray-700 dark:text-blue-400'
            : 'bg-blue-100 text-blue-800 dark:bg-gray-700 dark:text-blue-400',
    };
@endphp

<span {{ $attributes->merge(['class' => $baseClasses . ' ' . $sizeClasses . ' ' . $roundedClasses . ' ' . $colorClasses]) }}>
    {{ $slot }}
</span>
