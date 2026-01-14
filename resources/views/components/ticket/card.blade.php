@props([
    'ticket',
    'index' => 0,
    'showActions' => true,
])

@php
    $statusColors = [
        'active' => 'green',
        'used' => 'blue',
        'cancelled' => 'red',
        'expired' => 'gray',
    ];
    $statusColor = $statusColors[$ticket->status] ?? 'gray';
@endphp

<x-ui.card :padding="false" class="overflow-hidden">
    {{-- Ticket Header --}}
    <div class="bg-linear-to-r from-blue-600 to-indigo-600 px-6 py-3 flex justify-between items-center">
        <span class="text-white font-semibold">Penumpang {{ $index + 1 }}</span>
        <x-ui.badge :color="$statusColor" pill>
            {{ $ticket->status_label }}
        </x-ui.badge>
    </div>

    <div class="p-6">
        <div class="flex flex-col lg:flex-row lg:items-start gap-6">
            {{-- Passenger Info --}}
            <div class="flex-1 space-y-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nama Penumpang</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $ticket->passenger->name }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No. Tiket</p>
                        <p class="font-mono font-semibold text-blue-600 dark:text-blue-400 text-sm">{{ $ticket->ticket_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tipe ID</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst($ticket->passenger->id_type) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No. Identitas</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $ticket->passenger->id_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Berlaku Sampai</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $ticket->valid_until ? $ticket->valid_until->format('d/m/Y H:i') : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- QR Code --}}
            <div class="shrink-0 text-center">
                <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 inline-block">
                    @if($ticket->qr_code_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($ticket->qr_code_path))
                        @if(str_ends_with($ticket->qr_code_path, '.svg'))
                            <div class="w-32 h-32 lg:w-36 lg:h-36 mx-auto overflow-hidden flex items-center justify-center [&>svg]:w-full [&>svg]:h-full">
                                {!! \Illuminate\Support\Facades\Storage::disk('public')->get($ticket->qr_code_path) !!}
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $ticket->qr_code_path) }}"
                                 alt="QR Code"
                                 class="w-32 h-32 lg:w-36 lg:h-36 mx-auto object-contain">
                        @endif
                    @else
                        <div class="w-32 h-32 lg:w-36 lg:h-36 mx-auto flex items-center justify-center [&>svg]:w-full [&>svg]:h-full">
                            {!! QrCode::size(130)->margin(0)->generate(json_encode(['ticket_number' => $ticket->ticket_number, 'qr_code' => $ticket->qr_code])) !!}
                        </div>
                    @endif
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-mono break-all max-w-35">{{ $ticket->qr_code }}</p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        @if($showActions)
        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 flex flex-wrap gap-3">
            <x-ui.button
                :href="route('ticket.single', $ticket)"
                size="sm"
                color="primary">
                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Lihat Detail
            </x-ui.button>
            <x-ui.button
                size="sm"
                color="secondary"
                x-data
                @click="$dispatch('print-ticket', { ticketId: 'ticket-{{ $ticket->id }}' })">
                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </x-ui.button>
        </div>
        @endif
    </div>
</x-ui.card>
