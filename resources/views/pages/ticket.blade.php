<x-layouts.app :title="'Pesan Tiket - ' . config('app.name')">
    {{-- Hero Section --}}
    <section class="relative bg-center bg-no-repeat bg-cover py-20"
        style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=2070&auto=format&fit=crop');">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                    Pesan Tiket Fast Boat
                </h1>
                <p class="text-lg md:text-xl text-gray-200 max-w-2xl mx-auto drop-shadow">
                    Temukan jadwal terbaik dan pesan tiket perjalanan Anda dengan mudah
                </p>
            </div>
        </div>
    </section>

    {{-- Booking Search Form Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            @livewire('search-booking-form')
        </div>
    </section>

    {{-- Information Section --}}
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Cara Memesan Tiket</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    {{-- Step 1 --}}
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">1</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Pilih Rute</h3>
                        <p class="text-gray-600 text-sm">Pilih lokasi keberangkatan dan tujuan Anda</p>
                    </div>

                    {{-- Step 2 --}}
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">2</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Pilih Jadwal</h3>
                        <p class="text-gray-600 text-sm">Tentukan tanggal dan pilih jadwal yang tersedia</p>
                    </div>

                    {{-- Step 3 --}}
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">3</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Isi Data</h3>
                        <p class="text-gray-600 text-sm">Lengkapi data penumpang untuk pemesanan</p>
                    </div>

                    {{-- Step 4 --}}
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">4</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Bayar & Selesai</h3>
                        <p class="text-gray-600 text-sm">Lakukan pembayaran dan terima e-ticket Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Pertanyaan Umum</h2>
                
                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">
                            <i class="fa-solid fa-circle-question text-blue-500 mr-2"></i>
                            Bagaimana cara mendapatkan e-ticket?
                        </h3>
                        <p class="text-gray-600 text-sm">E-ticket akan dikirim ke email Anda setelah pembayaran berhasil. Anda juga dapat mengunduh tiket di halaman konfirmasi.</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">
                            <i class="fa-solid fa-circle-question text-blue-500 mr-2"></i>
                            Apakah bisa melakukan perubahan jadwal?
                        </h3>
                        <p class="text-gray-600 text-sm">Perubahan jadwal dapat dilakukan maksimal 24 jam sebelum keberangkatan. Hubungi customer service untuk bantuan.</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">
                            <i class="fa-solid fa-circle-question text-blue-500 mr-2"></i>
                            Apa saja metode pembayaran yang tersedia?
                        </h3>
                        <p class="text-gray-600 text-sm">Kami menerima pembayaran melalui transfer bank, kartu kredit/debit, e-wallet (GoPay, OVO, Dana), dan virtual account.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
