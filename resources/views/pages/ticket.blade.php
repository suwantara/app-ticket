<x-layouts.app :title="'Pesan Tiket - ' . config('app.name')">
    {{-- Hero Section --}}
    <x-header-section title="Pesan Tiket Fast Boat"
        subtitle="Temukan jadwal terbaik dan pesan tiket perjalanan Anda dengan mudah" />

    {{-- Booking Search Form Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            {{-- Search Form --}}
            <livewire:search-booking-form />

            {{-- Search Results (separate component) --}}
            <livewire:search-results />
        </div>
    </section>

    {{-- Information Section --}}
    <x-ticket-step-section />

    {{-- FAQ Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Pertanyaan Umum</h2>

                <div class="space-y-4">
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h3 class="font-semibold text-gray-800 mb-2">
                            <i class="fa-solid fa-circle-question text-blue-500 mr-2"></i>
                            Bagaimana cara mendapatkan e-ticket?
                        </h3>
                        <p class="text-gray-600 text-sm">E-ticket akan dikirim ke email Anda setelah pembayaran
                            berhasil. Anda juga dapat mengunduh tiket di halaman konfirmasi.</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h3 class="font-semibold text-gray-800 mb-2">
                            <i class="fa-solid fa-circle-question text-blue-500 mr-2"></i>
                            Apakah bisa melakukan perubahan jadwal?
                        </h3>
                        <p class="text-gray-600 text-sm">Perubahan jadwal dapat dilakukan maksimal 24 jam sebelum
                            keberangkatan. Hubungi customer service untuk bantuan.</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h3 class="font-semibold text-gray-800 mb-2">
                            <i class="fa-solid fa-circle-question text-blue-500 mr-2"></i>
                            Apa saja metode pembayaran yang tersedia?
                        </h3>
                        <p class="text-gray-600 text-sm">Kami menerima pembayaran melalui transfer bank, kartu
                            kredit/debit, e-wallet (GoPay, OVO, Dana), dan virtual account.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
