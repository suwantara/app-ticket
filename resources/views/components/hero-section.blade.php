<section class="relative min-h-125 flex items-center">
    {{-- LCP Optimization: Use img tag instead of background-image for faster discovery --}}
    <img src="{{ asset('img/hero-section.webp') }}" alt="Layanan Fast Boat Bali"
        class="absolute inset-0 w-full h-full object-cover -z-10" fetchpriority="high" loading="eager">

    <!-- Gradient overlay: dark on left, transparent on right -->
    <div class="absolute inset-0 bg-linear-to-r from-blue-900/40 via-blue-800/20 to-transparent"></div>

    <div class="container mx-auto px-4 py-16 relative z-10">
        <!-- Hero Content - Left Aligned -->
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 drop-shadow-lg leading-tight">
                Jelajahi Pesona Pulau & Destinasi Bahari Impian
            </h1>
            <p class="text-lg md:text-xl text-gray-100 max-w-xl drop-shadow-md mb-8 leading-relaxed">
                Layanan penyeberangan fast boat terbaik ke Nusa Penida, Gili, Lembongan, dan berbagai destinasi eksotis
                lainnya.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('ticket') }}"
                    class="inline-flex items-center justify-center bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-ship mr-2"></i> Pesan Tiket Sekarang
                </a>
                <a href="{{ route('ticket.search') }}"
                    class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-6 py-3 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-search mr-2"></i> Cek Tiket Saya
                </a>
            </div>
        </div>
    </div>
</section>
