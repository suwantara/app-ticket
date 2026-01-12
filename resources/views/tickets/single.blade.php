<x-layouts.app title="E-Ticket - {{ $ticket->ticket_number }}">
    <div class="min-h-screen bg-linear-to-br from-blue-50 to-indigo-100 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- E-Ticket Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden" id="ticket-printable">

                <!-- Header -->
                <div class="bg-linear-to-r from-blue-600 to-indigo-600 px-6 py-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold">E-TICKET</h1>
                            <p class="text-blue-100 text-sm mt-1">Ferry Booking System</p>
                        </div>
                        <div class="text-right">
                            @php
                                $statusClasses = match($ticket->status) {
                                    'active' => 'bg-green-400 text-green-900',
                                    'used' => 'bg-blue-400 text-blue-900',
                                    'cancelled' => 'bg-red-400 text-red-900',
                                    default => 'bg-gray-400 text-gray-900',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses }}">
                                {{ $ticket->status_label }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Ticket Body -->
                <div class="p-6">
                    <!-- Route Display -->
                    <div class="text-center mb-6 pb-6 border-b border-dashed border-gray-300">
                        <div class="flex items-center justify-center space-x-4">
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">{{ $ticket->order->schedule->route->origin->code ?? substr($ticket->order->schedule->route->origin->name, 0, 3) }}</p>
                                <p class="text-sm text-gray-500">{{ $ticket->order->schedule->route->origin->name }}</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                                <p class="text-xs text-gray-400 mt-1">{{ $ticket->order->schedule->ship->name }}</p>
                            </div>
                            <div class="text-left">
                                <p class="text-2xl font-bold text-gray-900">{{ $ticket->order->schedule->route->destination->code ?? substr($ticket->order->schedule->route->destination->name, 0, 3) }}</p>
                                <p class="text-sm text-gray-500">{{ $ticket->order->schedule->route->destination->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Passenger & Trip Details -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="col-span-2">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Nama Penumpang</p>
                            <p class="text-xl font-bold text-gray-900">{{ $ticket->passenger->name }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Tanggal</p>
                            <p class="font-semibold text-gray-900">{{ $ticket->order->travel_date->format('d M Y') }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Waktu Berangkat</p>
                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($ticket->order->schedule->departure_time)->format('H:i') }} WIB</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Tipe Identitas</p>
                            <p class="font-semibold text-gray-900">{{ strtoupper($ticket->passenger->id_type) }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">No. Identitas</p>
                            <p class="font-semibold text-gray-900">{{ $ticket->passenger->id_number }}</p>
                        </div>
                    </div>

                    <!-- Ticket Number -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider">No. Tiket</p>
                                <p class="font-mono text-lg font-bold text-blue-600">{{ $ticket->ticket_number }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 uppercase tracking-wider">No. Order</p>
                                <p class="font-mono text-sm text-gray-600">{{ $ticket->order->order_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div class="text-center mb-6">
                        <div class="inline-block bg-white p-4 rounded-2xl border-2 border-gray-200 shadow-inner">
                            @if($ticket->qr_code_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($ticket->qr_code_path))
                                @if(str_ends_with($ticket->qr_code_path, '.svg'))
                                    <div class="w-44 h-44 mx-auto overflow-hidden flex items-center justify-center [&>svg]:w-full [&>svg]:h-full">
                                        {!! \Illuminate\Support\Facades\Storage::disk('public')->get($ticket->qr_code_path) !!}
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $ticket->qr_code_path) }}"
                                         alt="QR Code"
                                         class="w-44 h-44 mx-auto object-contain">
                                @endif
                            @else
                                <div class="w-44 h-44 flex items-center justify-center [&>svg]:w-full [&>svg]:h-full">
                                    {!! QrCode::size(170)->margin(0)->generate(json_encode(['ticket_number' => $ticket->ticket_number, 'qr_code' => $ticket->qr_code])) !!}
                                </div>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Tunjukkan QR Code ini saat boarding</p>
                        <p class="font-mono text-xs text-gray-400 break-all max-w-50 mx-auto">{{ $ticket->qr_code }}</p>
                    </div>

                    <!-- Valid Info -->
                    <div class="bg-blue-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-blue-600">
                            <span class="font-medium">Berlaku:</span>
                            {{ $ticket->valid_from ? $ticket->valid_from->format('d/m/Y H:i') : '-' }}
                            s/d
                            {{ $ticket->valid_until ? $ticket->valid_until->format('d/m/Y H:i') : '-' }}
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tiket ini hanya berlaku untuk 1 orang dan tidak dapat dipindahtangankan
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex flex-wrap justify-center gap-4">
                <button onclick="printTicket()"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Tiket
                </button>

                <a href="{{ route('ticket.show', $ticket->order) }}"
                   class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition text-gray-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Lihat Semua Tiket
                </a>
            </div>

            <!-- Used Info (if ticket is used) -->
            @if($ticket->status === 'used')
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                <div class="flex">
                    <svg class="w-6 h-6 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-blue-800 font-medium">Tiket Sudah Digunakan</p>
                        <p class="text-blue-700 text-sm">
                            Digunakan pada: {{ $ticket->used_at ? $ticket->used_at->format('d/m/Y H:i') : '-' }}
                            @if($ticket->used_by)
                                oleh {{ $ticket->used_by }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #ticket-printable, #ticket-printable * {
                visibility: visible;
            }
            #ticket-printable {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>

    <script>
        function printTicket() {
            window.print();
        }
    </script>
</x-layouts.app>
