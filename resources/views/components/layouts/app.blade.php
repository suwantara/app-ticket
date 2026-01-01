<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>
<body class="bg-gray-50 pt-18">

    <x-navbar />

    <main>
        {{ $slot }}
    </main>

    <x-footer />

    @livewireScripts

    <script src="https://kit.fontawesome.com/260ad600f6.js" crossorigin="anonymous"></script>
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
