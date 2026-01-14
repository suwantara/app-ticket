<x-layouts.app>
    <x-slot:title>Pembayaran - {{ $order->order_number }}</x-slot>

    @push('styles')
    <style>
        .snap-container {
            width: 100%;
            min-height: 500px;
        }
        #snap-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #snap-modal iframe {
            border-radius: 10px;
            max-width: 480px;
            width: 100%;
            height: 600px;
        }
        .countdown {
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
    @endpush
<div class="min-h-screen bg-linear-to-b from-blue-50 to-white py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Flash Messages -->
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

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran</h1>
            <p class="text-gray-600">Selesaikan pembayaran untuk menyelesaikan pemesanan Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <!-- Order Info Header -->
                    <div class="bg-linear-to-r from-blue-600 to-blue-700 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-200 text-sm">Nomor Pesanan</p>
                                <p class="text-xl font-bold tracking-wider">{{ $order->order_number }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-blue-200 text-sm">Total Pembayaran</p>
                                <p class="text-2xl font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Countdown Timer -->
                    <div class="p-6 bg-yellow-50 border-b border-yellow-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-clock text-2xl text-yellow-600"></i>
                                <div>
                                    <p class="font-semibold text-yellow-800">Batas Waktu Pembayaran</p>
                                    <p class="text-sm text-yellow-600">{{ $order->expired_at->translatedFormat('d M Y, H:i') }} WIB</p>
                                </div>
                            </div>
                            <div class="countdown text-yellow-700" id="countdown">
                                --:--:--
                            </div>
                        </div>
                    </div>

                    <!-- Payment Options -->
                    <div class="p-6">
                        <h3 class="font-bold text-gray-800 mb-4">
                            <i class="fa-solid fa-credit-card mr-2 text-blue-600"></i> Pilih Metode Pembayaran
                        </h3>

                        <!-- Snap Button -->
                        <div class="space-y-4">
                            <button id="pay-button"
                                    class="w-full bg-linear-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white py-4 px-6 rounded-xl font-bold text-lg transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3">
                                <i class="fa-solid fa-wallet"></i>
                                <span>Bayar Sekarang</span>
                            </button>

                            <p class="text-center text-sm text-gray-500">
                                Powered by <strong>Midtrans</strong> - Berbagai metode pembayaran tersedia
                            </p>

                            <!-- Payment Methods Icons -->
                            <div class="flex flex-wrap justify-center gap-3 mt-4">
                                <div class="bg-gray-100 rounded-lg px-3 py-2 text-xs font-medium text-gray-600">
                                    <i class="fa-brands fa-cc-visa mr-1"></i> Visa
                                </div>
                                <div class="bg-gray-100 rounded-lg px-3 py-2 text-xs font-medium text-gray-600">
                                    <i class="fa-brands fa-cc-mastercard mr-1"></i> Mastercard
                                </div>
                                <div class="bg-gray-100 rounded-lg px-3 py-2 text-xs font-medium text-gray-600">
                                    <i class="fa-solid fa-building-columns mr-1"></i> Bank Transfer
                                </div>
                                <div class="bg-gray-100 rounded-lg px-3 py-2 text-xs font-medium text-gray-600">
                                    <i class="fa-solid fa-store mr-1"></i> Convenience Store
                                </div>
                                <div class="bg-gray-100 rounded-lg px-3 py-2 text-xs font-medium text-gray-600">
                                    <i class="fa-solid fa-wallet mr-1"></i> E-Wallet
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Badge -->
                    <div class="p-4 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                            <i class="fa-solid fa-shield-halved text-green-600"></i>
                            <span>Pembayaran aman & terenkripsi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fa-solid fa-receipt mr-2 text-blue-600"></i> Detail Pesanan
                    </h3>

                    <!-- Trip Info -->
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <div class="flex items-center gap-2 text-blue-600 font-semibold mb-2">
                            <i class="fa-solid fa-ship"></i>
                            <span>{{ $order->schedule->route->origin->name }} → {{ $order->schedule->route->destination->name }}</span>
                        </div>
                        <div class="text-sm space-y-1 text-gray-600">
                            <div class="flex justify-between">
                                <span>Tanggal</span>
                                <span class="font-medium">{{ $order->travel_date->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Waktu</span>
                                <span class="font-medium">{{ $order->schedule->departure_time_formatted }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Kapal</span>
                                <span class="font-medium">{{ $order->schedule->ship->name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Passengers -->
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Penumpang ({{ $order->passengers->count() }})</h4>
                        <div class="space-y-1 text-sm">
                            @foreach($order->passengers as $passenger)
                            <div class="flex justify-between text-gray-600">
                                <span>{{ $passenger->name }}</span>
                                <span class="text-xs bg-gray-100 px-2 py-0.5 rounded">{{ $passenger->type_label }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Kontak</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><i class="fa-solid fa-user w-5"></i> {{ $order->contact_name }}</p>
                            <p><i class="fa-solid fa-envelope w-5"></i> {{ $order->contact_email }}</p>
                            <p><i class="fa-solid fa-phone w-5"></i> {{ $order->contact_phone }}</p>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg">Total</span>
                        <span class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Back Link -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('booking.confirmation', $order) }}"
                           class="text-sm text-gray-500 hover:text-gray-700 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali ke Detail Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    // Countdown Timer
    const expiredAt = new Date('{{ $order->expired_at->toIso8601String() }}').getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = expiredAt - now;

        if (distance < 0) {
            document.getElementById('countdown').innerHTML = 'EXPIRED';
            document.getElementById('countdown').classList.add('text-red-600');
            document.getElementById('pay-button').disabled = true;
            document.getElementById('pay-button').classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        const hours = Math.floor(distance / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById('countdown').innerHTML =
            String(hours).padStart(2, '0') + ':' +
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);

    // Pay Button Handler
    document.getElementById('pay-button').addEventListener('click', function() {
        const snapToken = '{{ $snapToken }}';

        if (!snapToken) {
            alert('Token pembayaran tidak tersedia. Silakan refresh halaman.');
            return;
        }

        snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                window.location.href = '{{ route('payment.finish', $order) }}?transaction_status=settlement&order_id=' + result.order_id;
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                // For VA/Bank Transfer, redirect to confirmation page with pending status
                window.location.href = '{{ route('booking.confirmation', $order) }}?payment_pending=1';
            },
            onError: function(result) {
                console.log('Payment error:', result);
                window.location.href = '{{ route('payment.error', $order) }}';
            },
            onClose: function() {
                console.log('Payment popup closed');
                // Check if payment was completed or pending
                checkPaymentStatus();
            }
        });
    });

    // Check payment status
    function checkPaymentStatus() {
        fetch('{{ route('payment.status', $order) }}')
            .then(response => response.json())
            .then(data => {
                console.log('Payment status:', data);
                if (data.is_paid) {
                    window.location.href = '{{ route('ticket.show', $order) }}';
                } else if (data.payment_status === 'pending') {
                    // VA payment initiated, redirect to confirmation
                    window.location.href = '{{ route('booking.confirmation', $order) }}?payment_pending=1';
                }
            });
    }
</script>
@endpush

</x-layouts.app>
