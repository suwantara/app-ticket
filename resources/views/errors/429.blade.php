<x-layouts.app title="Terlalu Banyak Permintaan">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-red-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full text-center">
            {{-- Error Icon --}}
            <div class="mb-8">
                <div class="mx-auto w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-hand text-5xl text-orange-500"></i>
                </div>
            </div>

            {{-- Error Code --}}
            <h1 class="text-8xl font-bold text-orange-500 mb-4">429</h1>

            {{-- Error Title --}}
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Terlalu Banyak Permintaan</h2>

            {{-- Error Message --}}
            <p class="text-gray-600 mb-6">
                Anda telah mengirim terlalu banyak permintaan dalam waktu singkat.
                Mohon tunggu sebentar sebelum mencoba lagi.
            </p>

            {{-- Retry Timer --}}
            @isset($retryAfter)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <p class="text-sm text-gray-500 mb-2">Coba lagi dalam:</p>
                <div class="text-3xl font-bold text-orange-600" id="countdown">
                    {{ $retryAfter }} detik
                </div>
            </div>
            @endisset

            {{-- Actions --}}
            <div class="space-y-4">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    <i class="fa-solid fa-home mr-2"></i>
                    Kembali ke Beranda
                </a>

                <button onclick="window.location.reload()"
                        class="block w-full text-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fa-solid fa-refresh mr-2"></i>
                    Coba Lagi
                </button>
            </div>

            {{-- Security Notice --}}
            <div class="mt-8 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <div class="flex items-start">
                    <i class="fa-solid fa-shield-halved text-yellow-500 mr-3 mt-0.5"></i>
                    <div class="text-left">
                        <p class="text-sm font-medium text-yellow-800">Perlindungan Keamanan</p>
                        <p class="text-xs text-yellow-700 mt-1">
                            Pembatasan ini diterapkan untuk melindungi sistem dari penyalahgunaan.
                            Jika Anda merasa ini adalah kesalahan, silakan hubungi tim support.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @isset($retryAfter)
    <script>
        let countdown = {{ $retryAfter }};
        const countdownEl = document.getElementById('countdown');

        const timer = setInterval(() => {
            countdown--;
            if (countdown <= 0) {
                clearInterval(timer);
                countdownEl.textContent = 'Siap!';
                window.location.reload();
            } else {
                countdownEl.textContent = countdown + ' detik';
            }
        }, 1000);
    </script>
    @endisset
</x-layouts.app>
