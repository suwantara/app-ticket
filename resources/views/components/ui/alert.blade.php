@props([
    'type' => 'info', // info, success, warning, danger
    'dismissible' => false,
    'icon' => true,
])

@php
    $baseClasses = 'p-4 mb-4 text-sm rounded-lg';

    $typeClasses = match($type) {
        'success' => 'text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-300 dark:border-green-800',
        'warning' => 'text-yellow-800 bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 border border-yellow-300 dark:border-yellow-800',
        'danger', 'error' => 'text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-300 dark:border-red-800',
        default => 'text-blue-800 bg-blue-50 dark:bg-gray-800 dark:text-blue-400 border border-blue-300 dark:border-blue-800',
    };

    $iconSvg = match($type) {
        'success' => '<svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>',
        'warning' => '<svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>',
        'danger', 'error' => '<svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/></svg>',
        default => '<svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>',
    };
@endphp

<div {{ $attributes->merge(['class' => $baseClasses . ' ' . $typeClasses]) }}
     role="alert"
     @if($dismissible) x-data="{ show: true }" x-show="show" x-transition @endif>
    <div class="flex items-center">
        @if($icon)
            <span class="mr-3">{!! $iconSvg !!}</span>
        @endif
        <span class="sr-only">{{ ucfirst($type) }}</span>
        <div class="flex-1">
            {{ $slot }}
        </div>
        @if($dismissible)
            <button type="button"
                    @click="show = false"
                    class="ms-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex items-center justify-center h-8 w-8 hover:bg-opacity-20 hover:bg-gray-900"
                    aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        @endif
    </div>
</div>
