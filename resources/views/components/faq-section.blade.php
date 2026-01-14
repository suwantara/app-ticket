<!-- FAQ Section -->
<section class="py-20 bg-blue-900">

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-blue-100 max-w-2xl mx-auto">Temukan jawaban atas pertanyaan umum seputar pemesanan tiket fast
                boat, jadwal, dan pembayaran.</p>
        </div>

        <div class="mx-auto" x-data="{ activeAccordion: 1 }">
            <div class="space-y-4">
                <!-- Item 1 -->
                <div
                    class="bg-blue-950/50 backdrop-blur-sm border border-blue-800 rounded-2xl overflow-hidden transition-all duration-200 hover:border-blue-700">
                    <button @click="activeAccordion = activeAccordion === 1 ? null : 1"
                        class="flex items-center justify-between w-full p-5 text-left text-white transition-colors duration-200">
                        <span class="font-semibold text-lg">Bagaimana cara mendapatkan e-ticket?</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 1 }"></i>
                    </button>
                    <div x-show="activeAccordion === 1" x-collapse x-cloak>
                        <div class="p-5 pt-0 text-blue-100 border-t border-blue-800/50">
                            E-ticket akan dikirimkan secara otomatis ke alamat email yang Anda daftarkan segera setelah
                            pembayaran berhasil dikonfirmasi. Anda juga dapat mengunduh tiket melalui halaman Riwayat
                            Pemesanan di akun Anda.
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div
                    class="bg-blue-950/50 backdrop-blur-sm border border-blue-800 rounded-2xl overflow-hidden transition-all duration-200 hover:border-blue-700">
                    <button @click="activeAccordion = activeAccordion === 2 ? null : 2"
                        class="flex items-center justify-between w-full p-5 text-left text-white transition-colors duration-200">
                        <span class="font-semibold text-lg">Apakah bisa melakukan perubahan jadwal?</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 2 }"></i>
                    </button>
                    <div x-show="activeAccordion === 2" x-collapse x-cloak>
                        <div class="p-5 pt-0 text-blue-100 border-t border-blue-800/50">
                            Ya, perubahan jadwal (reschedule) dapat dilakukan maksimal 24 jam sebelum waktu
                            keberangkatan, tergantung pada ketersediaan kursi. Silakan hubungi Customer Service kami
                            melalui WhatsApp atau email untuk bantuan perubahan jadwal.
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div
                    class="bg-blue-950/50 backdrop-blur-sm border border-blue-800 rounded-2xl overflow-hidden transition-all duration-200 hover:border-blue-700">
                    <button @click="activeAccordion = activeAccordion === 3 ? null : 3"
                        class="flex items-center justify-between w-full p-5 text-left text-white transition-colors duration-200">
                        <span class="font-semibold text-lg">Apa saja metode pembayaran yang tersedia?</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 3 }"></i>
                    </button>
                    <div x-show="activeAccordion === 3" x-collapse x-cloak>
                        <div class="p-5 pt-0 text-blue-100 border-t border-blue-800/50">
                            Kami menerima berbagai metode pembayaran yang aman dan mudah, termasuk Transfer Bank (BCA,
                            Mandiri, BNI, BRI), Kartu Kredit/Debit (Visa, MasterCard), E-Wallet (GoPay, OVO, Dana,
                            LinkAja), dan QRIS.
                        </div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div
                    class="bg-blue-950/50 backdrop-blur-sm border border-blue-800 rounded-2xl overflow-hidden transition-all duration-200 hover:border-blue-700">
                    <button @click="activeAccordion = activeAccordion === 4 ? null : 4"
                        class="flex items-center justify-between w-full p-5 text-left text-white transition-colors duration-200">
                        <span class="font-semibold text-lg">Apakah tiket bisa dibatalkan (refund)?</span>
                        <i class="fa-solid fa-chevron-down transition-transform duration-200"
                            :class="{ 'rotate-180': activeAccordion === 4 }"></i>
                    </button>
                    <div x-show="activeAccordion === 4" x-collapse x-cloak>
                        <div class="p-5 pt-0 text-blue-100 border-t border-blue-800/50">
                            Kebijakan pembatalan bergantung pada operator kapal masing-masing. Umumnya, pembatalan yang
                            dilakukan H-2 akan dikenakan biaya administrasi. Mohon cek syarat dan ketentuan pada saat
                            pemesanan atau hubungi CS kami untuk info lebih lanjut.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="mt-12 text-center">
                <p class="text-blue-200 mb-4">Masih punya pertanyaan lain?</p>
                <a href="/contact"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-900 rounded-xl font-bold hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/20">
                    <i class="fa-solid fa-headset"></i>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
