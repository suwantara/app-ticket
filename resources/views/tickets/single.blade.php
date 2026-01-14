<x-layouts.app title="E-Ticket - {{ $ticket->ticket_number }}">
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- E-Ticket Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden" id="ticket-printable">

                <!-- Header -->
                <div class="bg-linear-to-r from-blue-600 to-blue-700 px-8 py-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold mb-1">E-TICKET</h1>
                            <p class="text-blue-100 text-sm">{{ config('app.name') }}</p>
                        </div>
                        <div class="text-right">
                            @php
                                $statusClasses = match ($ticket->status) {
                                    'active' => 'bg-green-100 text-green-700 border border-green-200',
                                    'used' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                    'cancelled' => 'bg-red-100 text-red-700 border border-red-200',
                                    default => 'bg-gray-100 text-gray-700 border border-gray-200',
                                };
                            @endphp
                            <span class="px-4 py-2 rounded-xl text-sm font-semibold {{ $statusClasses }}">
                                {{ $ticket->status_label }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Ticket Body -->
                <div class="p-8">
                    <!-- Route Display -->
                    <div class="text-center mb-8 pb-8 border-b-2 border-dashed border-gray-200">
                        <div class="flex items-center justify-center gap-8">
                            <div class="text-right">
                                <p class="text-3xl font-bold text-gray-900 mb-1">
                                    {{ $ticket->order->schedule->route->origin->code ?? substr($ticket->order->schedule->route->origin->name, 0, 3) }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $ticket->order->schedule->route->origin->name }}</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="bg-blue-100 p-3 rounded-full mb-2">
                                    <i class="fa-solid fa-ship text-blue-600 text-2xl"></i>
                                </div>
                                <div class="h-1 w-24 bg-linear-to-r from-blue-500 to-green-500 rounded-full mb-2"></div>
                                <p class="text-xs font-semibold text-gray-500">
                                    {{ $ticket->order->schedule->ship->name }}</p>
                            </div>
                            <div class="text-left">
                                <p class="text-3xl font-bold text-gray-900 mb-1">
                                    {{ $ticket->order->schedule->route->destination->code ?? substr($ticket->order->schedule->route->destination->name, 0, 3) }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $ticket->order->schedule->route->destination->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Passenger Info -->
                    <div class="bg-blue-50 rounded-xl p-6 mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-user text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold">Nama Penumpang
                                </p>
                                <p class="text-2xl font-bold text-gray-900">{{ $ticket->passenger->name }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-1">Tipe</p>
                                <p class="text-sm font-medium text-gray-900">{{ $ticket->passenger->type_label }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-1">Jenis
                                    Kelamin</p>
                                <p class="text-sm font-medium text-gray-900">{{ $ticket->passenger->gender_label }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Trip Details -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-2">
                                <i class="fa-regular fa-calendar mr-1 text-blue-600"></i> Tanggal Keberangkatan
                            </p>
                            <p class="text-lg font-bold text-gray-900">
                                {{ $ticket->order->travel_date->translatedFormat('d M Y') }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-2">
                                <i class="fa-regular fa-clock mr-1 text-green-600"></i> Waktu Berangkat
                            </p>
                            <p class="text-lg font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($ticket->order->schedule->departure_time)->format('H:i') }}
                                WIB</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-2">
                                <i class="fa-solid fa-id-card mr-1 text-purple-600"></i> Tipe Identitas
                            </p>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ strtoupper($ticket->passenger->id_type) }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-2">
                                <i class="fa-solid fa-hashtag mr-1 text-orange-600"></i> No. Identitas
                            </p>
                            <p class="text-sm font-semibold text-gray-900">{{ $ticket->passenger->id_number ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Ticket Number -->
                    <div class="bg-linear-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6 border border-blue-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-2">Nomor Tiket
                                </p>
                                <p class="font-mono text-xl font-bold text-blue-600">{{ $ticket->ticket_number }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-2">Nomor Order
                                </p>
                                <p class="font-mono text-lg font-semibold text-gray-700">
                                    {{ $ticket->order->order_number }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div class="text-center mb-6">
                        <div class="inline-block bg-white p-6 rounded-2xl border-4 border-gray-100 shadow-lg">
                            @if ($ticket->qr_code_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($ticket->qr_code_path))
                                @if (str_ends_with($ticket->qr_code_path, '.svg'))
                                    <div
                                        class="w-52 h-52 mx-auto overflow-hidden flex items-center justify-center [&>svg]:w-full [&>svg]:h-full">
                                        {!! \Illuminate\Support\Facades\Storage::disk('public')->get($ticket->qr_code_path) !!}
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $ticket->qr_code_path) }}" alt="QR Code"
                                        class="w-52 h-52 mx-auto object-contain">
                                @endif
                            @else
                                <div class="w-52 h-52 flex items-center justify-center [&>svg]:w-full [&>svg]:h-full">
                                    {!! QrCode::size(200)->margin(0)->generate(json_encode(['ticket_number' => $ticket->ticket_number, 'qr_code' => $ticket->qr_code])) !!}
                                </div>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mt-4 font-semibold">
                            <i class="fa-solid fa-qrcode mr-2 text-blue-600"></i>
                            Tunjukkan QR Code ini saat boarding
                        </p>
                        <p class="font-mono text-xs text-gray-400 mt-1 break-all max-w-xs mx-auto">
                            {{ $ticket->qr_code }}</p>
                    </div>

                    <!-- Valid Info -->
                    <div class="bg-green-50 border-l-4 border-green-500 rounded-r-xl p-4 text-center">
                        <p class="text-sm text-green-700 font-semibold">
                            <i class="fa-solid fa-check-circle mr-1"></i>
                            <span class="font-bold">Berlaku:</span>
                            {{ $ticket->valid_from ? $ticket->valid_from->translatedFormat('d/m/Y H:i') : '-' }}
                            s/d
                            {{ $ticket->valid_until ? $ticket->valid_until->translatedFormat('d/m/Y H:i') : '-' }}
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-8 py-5 border-t border-gray-200">
                    <div class="flex items-center justify-center text-sm text-gray-600">
                        <i class="fa-solid fa-info-circle mr-2 text-blue-500"></i>
                        <span class="font-medium">Tiket ini hanya berlaku untuk 1 orang dan tidak dapat
                            dipindahtangankan</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <button onclick="printTicket()"
                    class="inline-flex items-center px-8 py-4 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition font-bold shadow-lg hover:shadow-xl cursor-pointer">
                    <i class="fa-solid fa-print mr-2"></i>
                    Cetak Tiket
                </button>

                <a href="{{ route('ticket.show', $ticket->order) }}"
                    class="inline-flex items-center px-8 py-4 bg-white border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition text-gray-700 font-bold shadow-md hover:shadow-lg">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Lihat Semua Tiket
                </a>

                <a href="{{ route('ticket.download', $ticket) }}"
                    class="inline-flex items-center px-8 py-4 bg-linear-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl transition font-bold shadow-lg hover:shadow-xl">
                    <i class="fa-solid fa-download mr-2"></i>
                    Download PDF
                </a>
            </div>

            <!-- Used Info (if ticket is used) -->
            @if ($ticket->status === 'used')
                <div class="mt-8 bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-xl shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-check text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-blue-900 font-bold text-lg mb-1">Tiket Sudah Digunakan</p>
                            <p class="text-blue-700 text-sm">
                                <i class="fa-regular fa-clock mr-1"></i>
                                Digunakan pada: <span
                                    class="font-semibold">{{ $ticket->used_at ? $ticket->used_at->translatedFormat('d/m/Y H:i') : '-' }}</span>
                                @if ($ticket->used_by)
                                    <br><i class="fa-solid fa-user mr-1"></i>Oleh: <span
                                        class="font-semibold">{{ $ticket->used_by }}</span>
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

            #ticket-printable,
            #ticket-printable * {
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
