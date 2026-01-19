@props(['title' => config('app.name'), 'hideNavbar' => false, 'hideFooter' => false])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>
    @if (isset($description))
        <meta name="description" content="{{ $description }}">
    @endif

    {{-- Preconnect to external domains for faster loading --}}
    <link rel="preconnect" href="https://res.cloudinary.com" crossorigin>
    <link rel="preconnect" href="https://ka-f.fontawesome.com" crossorigin>
    <link rel="preconnect" href="https://kit.fontawesome.com" crossorigin>
    <link rel="dns-prefetch" href="https://images.unsplash.com">

    {{-- FontAwesome - defer to prevent render blocking --}}
    <script src="https://kit.fontawesome.com/260ad600f6.js" crossorigin="anonymous" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    {{-- Alpine is provided by Livewire; avoid loading Alpine twice --}}

    @stack('styles')
</head>

<body class="bg-gray-50 {{ $hideNavbar ? '' : 'pt-18' }}">

    @if (!$hideNavbar)
        <x-navbar />
    @endif

    <main>
        {{ $slot }}
    </main>

    @if (!$hideFooter)
        <x-footer />
    @endif

    {{-- Alert Modal Component --}}
    <x-alert-modal />

    {{-- Toast Notifications for Livewire --}}
    <div x-data="{ show: false, message: '', type: 'success' }"
        x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 4000)"
        x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2" class="fixed bottom-4 right-4 z-50" style="display: none;">
        <div class="flex items-center gap-3 px-6 py-4 rounded-lg shadow-lg"
            :class="{
                'bg-green-500 text-white': type === 'success',
                'bg-red-500 text-white': type === 'error',
                'bg-yellow-500 text-white': type === 'warning',
                'bg-blue-500 text-white': type === 'info',
            }">
            <template x-if="type === 'success'">
                <i class="fa-solid fa-check-circle text-xl"></i>
            </template>
            <template x-if="type === 'error'">
                <i class="fa-solid fa-times-circle text-xl"></i>
            </template>
            <template x-if="type === 'warning'">
                <i class="fa-solid fa-exclamation-circle text-xl"></i>
            </template>
            <template x-if="type === 'info'">
                <i class="fa-solid fa-info-circle text-xl"></i>
            </template>
            <span x-text="message" class="font-medium"></span>
            <button @click="show = false" class="ml-2 hover:opacity-75 cursor-pointer">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    </div>

    @livewireScripts

    @stack('scripts')


    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.hook('commit', () => {
                if (typeof initFlowbite === 'function') {
                    initFlowbite();
                }
            });
        });
    </script>

</body>

</html>
