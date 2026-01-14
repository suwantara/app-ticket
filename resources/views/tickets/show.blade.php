<x-layouts.app title="E-Ticket - {{ $order->order_number }}">
    <div class="min-h-screen bg-linear-to-br from-blue-50 to-indigo-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">E-Ticket</h1>
                <p class="text-gray-600">Order #{{ $order->order_number }}</p>
            </div>

            <!-- Success Alert -->
            @if($order->isPaid())
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-green-700 font-medium">Pembayaran Berhasil!</p>
                        <p class="text-green-600 text-sm">Tiket Anda sudah aktif dan siap digunakan.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Trip Info Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                <div class="bg-linear-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-white font-semibold text-lg">Informasi Perjalanan</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Route -->
                        <div class="flex items-center space-x-4">
                            <div class="shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Rute</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $order->schedule->route->origin->name }}
                                    <span class="text-blue-500 mx-2">→</span>
                                    {{ $order->schedule->route->destination->name }}
                                </p>
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="flex items-center space-x-4">
                            <div class="shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Keberangkatan</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $order->travel_date->format('l, d F Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Time -->
                        <div class="flex items-center space-x-4">
                            <div class="shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Waktu Keberangkatan</p>
                                <p class="font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($order->schedule->departure_time)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>

                        <!-- Ship -->
                        <div class="flex items-center space-x-4">
                            <div class="shrink-0">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Kapal</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $order->schedule->ship->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets -->
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-gray-900">Tiket Penumpang ({{ $order->tickets->count() }})</h2>

                @foreach($order->tickets as $index => $ticket)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden ticket-card" id="ticket-{{ $ticket->id }}">
                    <!-- Ticket Header -->
                    <div class="bg-linear-to-r from-blue-600 to-indigo-600 px-6 py-3 flex justify-between items-center">
                        <span class="text-white font-semibold">Penumpang {{ $index + 1 }}</span>
                        @php
                            $statusClasses = match($ticket->status) {
                                'active' => 'bg-green-100 text-green-800',
                                'used' => 'bg-blue-100 text-blue-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses }}">
                            {{ $ticket->status_label }}
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-start gap-6">
                            <!-- Passenger Info -->
                            <div class="flex-1">
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500">Nama Penumpang</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $ticket->passenger->name }}</p>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">No. Tiket</p>
                                        <p class="font-mono font-semibold text-blue-600">{{ $ticket->ticket_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tipe ID</p>
                                        <p class="font-medium text-gray-900">{{ ucfirst($ticket->passenger->id_type) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">No. Identitas</p>
                                        <p class="font-medium text-gray-900">{{ $ticket->passenger->id_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Berlaku Sampai</p>
                                        <p class="font-medium text-gray-900">
                                            {{ $ticket->valid_until ? $ticket->valid_until->format('d/m/Y H:i') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- QR Code -->
                            <div class="shrink-0 text-center">
                                <div class="bg-white p-4 rounded-xl border-2 border-dashed border-gray-200 inline-block">
                                    @if($ticket->qr_code_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($ticket->qr_code_path))
                                        @if(str_ends_with($ticket->qr_code_path, '.svg'))
                                            <div class="w-36 h-36 mx-auto overflow-hidden flex items-center justify-center [&>svg]:w-full [&>svg]:h-full">
                                                {!! \Illuminate\Support\Facades\Storage::disk('public')->get($ticket->qr_code_path) !!}
                                            </div>
                                        @else
                                            <img src="{{ asset('storage/' . $ticket->qr_code_path) }}"
                                                 alt="QR Code"
                                                 class="w-36 h-36 mx-auto object-contain">
                                        @endif
                                    @else
                                        <div class="w-36 h-36 mx-auto flex items-center justify-center [&>svg]:w-full [&>svg]:h-full">
                                            {!! QrCode::size(140)->margin(0)->generate(json_encode(['ticket_number' => $ticket->ticket_number, 'qr_code' => $ticket->qr_code])) !!}
                                        </div>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-2 font-mono break-all max-w-37.5">{{ $ticket->qr_code }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ticket Footer -->
                        <div class="mt-6 pt-4 border-t border-gray-200 flex flex-wrap gap-3">
                            <a href="{{ route('ticket.single', $ticket) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Lihat Detail
                            </a>
                            <button onclick="printTicket('ticket-{{ $ticket->id }}')"
                                    class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                Cetak
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Important Notice -->
            <div class="mt-8 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                <div class="flex">
                    <svg class="w-6 h-6 text-yellow-400 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <p class="text-yellow-800 font-medium">Penting!</p>
                        <ul class="text-yellow-700 text-sm mt-1 list-disc list-inside">
                            <li>Tunjukkan QR Code saat boarding</li>
                            <li>Harap tiba di pelabuhan minimal 30 menit sebelum keberangkatan</li>
                            <li>Bawa identitas asli sesuai data yang didaftarkan</li>
                            <li>Tiket tidak dapat dipindahtangankan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition text-gray-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Kembali ke Beranda
                </a>
                <a href="{{ route('ticket.pdf.download', ['orderNumber' => $order->order_number, 'token' => \App\Http\Controllers\TicketPdfController::generateToken($order)]) }}"
                   class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </a>
                <a href="{{ route('booking.form') }}"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Pesan Tiket Lagi
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function printTicket(ticketId) {
            const ticket = document.getElementById(ticketId);
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Print Ticket</title>
                    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
                    <style>
                        @media print {
                            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                        }
                    </style>
                </head>
                <body class="p-8">
                    ${ticket.outerHTML}
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.onload = function() {
                printWindow.print();
            };
        }
    </script>
    @endpush
</x-layouts.app>
