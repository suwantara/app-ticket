<x-layouts.app :title="'Cari Tiket - ' . config('app.name')">
    {{-- Hero Section --}}
    <section class="relative bg-center bg-no-repeat bg-cover py-16"
        style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=2070&auto=format&fit=crop');">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 drop-shadow-lg">
                    Cari Tiket Anda
                </h1>
                <p class="text-lg text-gray-200 max-w-2xl mx-auto drop-shadow">
                    Masukkan nomor tiket, nomor pesanan, atau kode QR untuk menemukan tiket Anda
                </p>
            </div>
        </div>
    </section>

    {{-- Search Form Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-xl mx-auto">
                {{-- Error Message --}}
                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{-- Search Card --}}
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <form action="{{ route('ticket.search') }}" method="GET">
                        <div class="mb-6">
                            <label for="query" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Tiket / Nomor Pesanan
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="query" id="query"
                                    class="block w-full pl-11 pr-4 py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg"
                                    placeholder="Contoh: TKT-XXXXXX atau ORD-XXXXXX" value="{{ request('query') }}"
                                    autofocus required minlength="3">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Anda dapat mencari menggunakan nomor tiket (TKT-xxx), nomor pesanan (ORD-xxx), atau kode
                                QR
                            </p>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-search"></i>
                            Cari Tiket
                        </button>
                    </form>
                </div>

                {{-- Help Info --}}
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info"></i>
                        Cara Menemukan Nomor Tiket
                    </h3>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-envelope mt-1 text-blue-500"></i>
                            <span>Cek email konfirmasi pemesanan Anda</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-file-pdf mt-1 text-blue-500"></i>
                            <span>Lihat pada e-ticket PDF yang sudah Anda download</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-qrcode mt-1 text-blue-500"></i>
                            <span>Scan QR code pada tiket Anda menggunakan kamera</span>
                        </li>
                    </ul>
                </div>

                {{-- Back Link --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}"
                        class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
