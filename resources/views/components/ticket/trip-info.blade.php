@props([
    'order',
])

<x-ui.card :padding="false" class="overflow-hidden">
    <x-slot:header>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Informasi Perjalanan
        </h2>
    </x-slot:header>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Route --}}
            <x-ticket.info-item
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
                iconBg="blue"
                label="Rute">
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ $order->schedule->route->origin->name }}
                </span>
                <span class="text-blue-500 mx-2">→</span>
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ $order->schedule->route->destination->name }}
                </span>
            </x-ticket.info-item>

            {{-- Date --}}
            <x-ticket.info-item
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'
                iconBg="green"
                label="Tanggal Keberangkatan">
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ $order->travel_date->translatedFormat('l, d F Y') }}
                </span>
            </x-ticket.info-item>

            {{-- Time --}}
            <x-ticket.info-item
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                iconBg="yellow"
                label="Waktu Keberangkatan">
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($order->schedule->departure_time)->format('H:i') }} WIB
                </span>
            </x-ticket.info-item>

            {{-- Ship --}}
            <x-ticket.info-item
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>'
                iconBg="purple"
                label="Kapal">
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ $order->schedule->ship->name }}
                </span>
            </x-ticket.info-item>
        </div>
    </div>
</x-ui.card>
