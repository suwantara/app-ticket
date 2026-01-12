<x-layouts.app>
    <x-slot:title>Konfirmasi Pemesanan - {{ $order->order_number }}</x-slot>
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Flash Messages -->
        @if(session()->has('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            <i class="fa-solid fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        @if(session()->has('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <i class="fa-solid fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
        @endif

        @if(session()->has('warning'))
        <div class="mb-6 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
            <i class="fa-solid fa-exclamation-triangle mr-2"></i>{{ session('warning') }}
        </div>
        @endif

        <!-- Payment Pending Alert (from VA/Bank Transfer) -->
        @if(request()->has('payment_pending'))
        <div class="mb-6 p-6 bg-blue-50 border border-blue-300 text-blue-800 rounded-lg">
            <div class="flex items-start">
                <i class="fa-solid fa-info-circle text-2xl mr-4 mt-1"></i>
                <div>
                    <h3 class="font-bold text-lg mb-2">Instruksi Pembayaran Virtual Account</h3>
                    <p class="mb-3">Pembayaran Anda sedang diproses. Silakan selesaikan pembayaran melalui ATM, Mobile Banking, atau Internet Banking sesuai dengan nomor Virtual Account yang telah diberikan.</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        <li>Pembayaran akan terverifikasi otomatis dalam beberapa menit</li>
                        <li>Anda akan menerima notifikasi email setelah pembayaran berhasil</li>
                        <li>Simpan bukti pembayaran untuk referensi</li>
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Success/Status Message -->
        <div class="text-center mb-8">
            @if($order->isPaid())
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <i class="fa-solid fa-check-circle text-5xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
            <p class="text-gray-600">E-Ticket Anda telah aktif dan siap digunakan.</p>
            @elseif($order->isExpired())
            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                <i class="fa-solid fa-times-circle text-5xl text-red-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan Kadaluarsa</h1>
            <p class="text-gray-600">Batas waktu pembayaran telah lewat.</p>
            @elseif($order->status === 'cancelled')
            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                <i class="fa-solid fa-ban text-5xl text-red-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan Dibatalkan</h1>
            <p class="text-gray-600">Pesanan ini telah dibatalkan.</p>
            @else
            <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 rounded-full mb-4">
                <i class="fa-solid fa-clock text-5xl text-yellow-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Menunggu Pembayaran</h1>
            <p class="text-gray-600">Selesaikan pembayaran untuk mengaktifkan tiket Anda.</p>
            @endif
        </div>

        <!-- Order Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <!-- Order Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-200 text-sm">Nomor Pesanan</p>
                        <p class="text-2xl font-bold tracking-wider">{{ $order->order_number }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                     {{ $order->payment_status === 'paid' ? 'bg-green-500' : 'bg-yellow-500' }}">
                            <i class="fa-solid fa-circle text-xs mr-2"></i>
                            {{ $order->payment_status === 'paid' ? 'Lunas' : 'Menunggu Pembayaran' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Trip Details -->
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4">
                    <i class="fa-solid fa-ship text-blue-600 mr-2"></i> Detail Perjalanan
                </h3>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex-1">
                            <p class="text-sm text-gray-500">Dari</p>
                            <p class="font-bold text-lg">{{ $order->schedule->route->origin->name }}</p>
                        </div>
                        <div class="text-gray-400">
                            <i class="fa-solid fa-arrow-right text-2xl"></i>
                        </div>
                        <div class="flex-1 text-right">
                            <p class="text-sm text-gray-500">Tujuan</p>
                            <p class="font-bold text-lg">{{ $order->schedule->route->destination->name }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Tanggal</p>
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($order->travel_date)->translatedFormat('l, d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Waktu Berangkat</p>
                            <p class="font-semibold">{{ $order->schedule->departure_time_formatted }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Kapal</p>
                            <p class="font-semibold">{{ $order->schedule->ship->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Kelas</p>
                            <p class="font-semibold">{{ ucfirst($order->schedule->ship->class) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4">
                    <i class="fa-solid fa-address-card text-blue-600 mr-2"></i> Informasi Kontak
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Nama</p>
                        <p class="font-semibold">{{ $order->contact_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-semibold">{{ $order->contact_email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Telepon</p>
                        <p class="font-semibold">{{ $order->contact_phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Passengers -->
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4">
                    <i class="fa-solid fa-users text-blue-600 mr-2"></i> Daftar Penumpang
                </h3>
                
                <div class="space-y-3">
                    @foreach($order->passengers as $index => $passenger)
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-sm">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <p class="font-semibold">{{ $passenger->name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $passenger->type_label }} • {{ $passenger->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Kode Tiket</p>
                            <p class="font-mono font-bold text-blue-600">{{ $passenger->ticket_code }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="p-6 bg-gray-50">
                <h3 class="font-bold text-gray-800 mb-4">
                    <i class="fa-solid fa-receipt text-blue-600 mr-2"></i> Ringkasan Pembayaran
                </h3>
                
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tiket ({{ $order->passengers->count() }} penumpang)</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Admin</span>
                        <span>Rp 0</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="font-bold text-lg">Total Pembayaran</span>
                    <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>

                @if($order->payment_status === 'pending' || $order->payment_status === 'unpaid')
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-clock text-yellow-600 mt-1"></i>
                        <div>
                            <p class="font-semibold text-yellow-800">Menunggu Pembayaran</p>
                            <p class="text-sm text-yellow-700">
                                Silakan selesaikan pembayaran sebelum 
                                <strong>{{ $order->expired_at->translatedFormat('d M Y, H:i') }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
                @elseif($order->payment_status === 'paid')
                <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-green-600 mt-1"></i>
                        <div>
                            <p class="font-semibold text-green-800">Pembayaran Lunas</p>
                            <p class="text-sm text-green-700">
                                Dibayar pada {{ $order->paid_at?->translatedFormat('d M Y, H:i') }}
                                @if($order->payment_method)
                                via {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if($order->canBePaid())
            <a href="{{ route('payment.show', $order) }}"
               class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg font-bold text-lg transition-all shadow-lg">
                <i class="fa-solid fa-credit-card mr-2"></i> Bayar Sekarang
            </a>
            @endif
            <a href="{{ route('home') }}"
               class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-colors">
                <i class="fa-solid fa-home mr-2"></i> Kembali ke Beranda
            </a>
            @if($order->isPaid())
            <a href="{{ route('ticket.pdf.download', ['orderNumber' => $order->order_number, 'token' => \App\Http\Controllers\TicketPdfController::generateToken($order)]) }}"
               class="inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors">
                <i class="fa-solid fa-file-pdf mr-2"></i> Download PDF
            </a>
            <a href="{{ route('ticket.pdf.view', ['orderNumber' => $order->order_number, 'token' => \App\Http\Controllers\TicketPdfController::generateToken($order)]) }}"
               target="_blank"
               class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">
                <i class="fa-solid fa-eye mr-2"></i> Lihat E-Ticket
            </a>
            @endif
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h4 class="font-semibold text-blue-800 mb-3">
                <i class="fa-solid fa-info-circle mr-2"></i> Informasi Penting
            </h4>
            <ul class="space-y-2 text-sm text-blue-700">
                <li class="flex items-start gap-2">
                    <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                    E-Ticket telah dikirim ke email <strong>{{ $order->contact_email }}</strong>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                    Harap hadir di pelabuhan minimal <strong>30 menit</strong> sebelum keberangkatan
                </li>
                <li class="flex items-start gap-2">
                    <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                    Bawa identitas asli (KTP/Passport) sesuai dengan yang didaftarkan
                </li>
                <li class="flex items-start gap-2">
                    <i class="fa-solid fa-check text-blue-500 mt-1"></i>
                    Tunjukkan e-ticket saat check-in di pelabuhan
                </li>
            </ul>
        </div>
    </div>
</div>

</x-layouts.app>
