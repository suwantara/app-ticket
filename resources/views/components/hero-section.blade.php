<section class="relative bg-center bg-no-repeat bg-cover min-h-125 flex items-center"
    style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=2070&auto=format&fit=crop');">

    <div class="container mx-auto px-4 py-16">
        <!-- Hero Content -->
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 drop-shadow-lg">
                Jelajahi Keindahan Laut Indonesia
            </h1>
            <p class="text-lg md:text-xl text-gray-200 max-w-3xl mx-auto drop-shadow mb-8">
                Pesan tiket fast boat Anda sekarang dan nikmati perjalanan cepat & nyaman ke destinasi impian Anda
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('ticket') }}"
                   class="inline-flex items-center justify-center bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-8 py-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer">
                    <i class="fa-solid fa-ship mr-2"></i> Pesan Tiket Sekarang
                </a>
                <a href="{{ route('ticket.search') }}"
                   class="inline-flex items-center justify-center bg-white/90 hover:bg-white text-gray-800 font-semibold px-8 py-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer">
                    <i class="fa-solid fa-search mr-2"></i> Cek Tiket Saya
                </a>
            </div>
        </div>
    </div>
</section>
