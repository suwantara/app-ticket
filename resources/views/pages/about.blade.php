<x-layouts.app :title="$page->meta_title ?? 'Tentang Kami'">
    {{-- Hero Section --}}
    <x-header-section title="Tentang Kami"
        subtitle="Temukan jadwal terbaik dan pesan tiket perjalanan Anda dengan mudah" />

    {{-- Company Overview --}}
    <section class="py-16 lg:py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center max-w-6xl mx-auto">
                {{-- Image --}}
                <div class="relative order-2 lg:order-1">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="{{ asset('img/about-hero.jpg') }}" alt="SemabuHills Team"
                            class="w-full h-80 md:h-96 object-cover"
                            onerror="this.src='https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600'">
                        {{-- Overlay Badge --}}
                        <div
                            class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm rounded-xl px-4 py-3 shadow-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-award text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">Terpercaya</p>
                                    <p class="text-sm text-gray-600">Sejak 2019</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Decorative --}}
                    <div class="absolute -z-10 -bottom-4 -right-4 w-full h-full bg-yellow-500/20 rounded-2xl"></div>
                </div>

                {{-- Content --}}
                <div class="order-1 lg:order-2">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">
                        Menghubungkan Anda dengan Keindahan Nusa Penida
                    </h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        <strong>SemabuHills</strong> adalah perusahaan agen perjalanan yang berlokasi di Nusa Penida,
                        Bali.
                        Kami berdedikasi untuk memberikan pengalaman perjalanan terbaik dengan menyediakan layanan
                        pemesanan
                        tiket fast boat yang mudah, aman, dan terjangkau.
                    </p>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Dengan jaringan operator kapal terluas dan sistem booking online yang modern, kami memastikan
                        setiap perjalanan Anda berjalan lancar dari awal hingga akhir. Tim kami yang berpengalaman siap
                        membantu Anda menemukan rute dan jadwal terbaik sesuai kebutuhan.
                    </p>

                    {{-- Quick Stats --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <div class="text-2xl md:text-3xl font-bold text-blue-900">5+</div>
                            <div class="text-sm text-gray-600">Tahun</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <div class="text-2xl md:text-3xl font-bold text-blue-900">50K+</div>
                            <div class="text-sm text-gray-600">Pelanggan</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-xl">
                            <div class="text-2xl md:text-3xl font-bold text-blue-900">20+</div>
                            <div class="text-sm text-gray-600">Rute</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Vision & Mission --}}
    <section class="py-16 lg:py-20 bg-linear-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Tujuan Kami</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                {{-- Vision --}}
                <div
                    class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-900 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-eye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Visi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Menjadi platform pemesanan tiket fast boat terdepan di Indonesia yang menghubungkan
                        wisatawan dengan destinasi-destinasi eksotis di kepulauan Nusantara, khususnya
                        Nusa Penida dan sekitarnya.
                    </p>
                </div>

                {{-- Mission --}}
                <div
                    class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-yellow-500 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-bullseye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Misi</h3>
                    <ul class="text-gray-600 space-y-3">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-green-500 mt-1"></i>
                            <span>Menyediakan layanan pemesanan yang mudah dan transparan</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-green-500 mt-1"></i>
                            <span>Menjamin keamanan dan kenyamanan setiap perjalanan</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-green-500 mt-1"></i>
                            <span>Bermitra dengan operator kapal terpercaya</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-check text-green-500 mt-1"></i>
                            <span>Memberikan harga kompetitif tanpa biaya tersembunyi</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Values --}}
    <x-feature-section />

    {{-- Statistics --}}
    <section class="py-16 lg:py-20 bg-blue-900 relative overflow-hidden">

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Pencapaian Kami</h2>
                <p class="text-blue-200">Angka yang membuktikan dedikasi kami</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 max-w-5xl mx-auto">
                <div class="text-center">
                    <div class="w-20 h-20 bg-yellow-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-calendar-check text-yellow-500 text-3xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">5+</div>
                    <div class="text-blue-200">Tahun Pengalaman</div>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-yellow-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-users text-yellow-500 text-3xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">50K+</div>
                    <div class="text-blue-200">Pelanggan Puas</div>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-yellow-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-route text-yellow-500 text-3xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">20+</div>
                    <div class="text-blue-200">Rute Tersedia</div>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 bg-yellow-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-handshake text-yellow-500 text-3xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold text-white mb-2">15+</div>
                    <div class="text-blue-200">Partner Operator</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Info --}}
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Informasi Kontak</h2>
                    <p class="text-gray-600">Kami siap melayani pertanyaan dan kebutuhan Anda</p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    {{-- Address --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-location-dot text-blue-900 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Alamat</h3>
                        <p class="text-gray-600 text-sm">
                            Jl. Raya Semabu, Nusa Penida<br>
                            Klungkung, Bali 80771
                        </p>
                    </div>

                    {{-- Phone --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-brands fa-whatsapp text-green-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">WhatsApp</h3>
                        <p class="text-gray-600 text-sm">
                            <a href="https://wa.me/6281234567890" class="hover:text-blue-600 transition-colors">
                                +62 812-3456-7890
                            </a>
                        </p>
                    </div>

                    {{-- Email --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                        <div
                            class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-envelope text-yellow-600 text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Email</h3>
                        <p class="text-gray-600 text-sm">
                            <a href="mailto:info@semabuhills.com" class="hover:text-blue-600 transition-colors">
                                info@semabuhills.com
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <x-cta-section />
</x-layouts.app>
