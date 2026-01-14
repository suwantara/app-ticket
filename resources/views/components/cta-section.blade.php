<section class="relative bg-center bg-no-repeat bg-cover min-h-125 flex items-center"
    style="background-image: url({{ asset('img/hero-section.png') }})">

    <!-- Gradient overlay: dark on left, transparent on right -->
    <div class="absolute inset-0 bg-linear-to-r from-blue-900/40 via-blue-800/20 to-transparent"></div>

    <div class="container mx-auto px-4 py-16 relative z-10">
        <!-- Hero Content - Left Aligned -->
        <div class="max-w-2xl">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 drop-shadow-lg leading-tight">
                Siap Berangkat?
            </h1>
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4 drop-shadow-lg">
                Amankan Tiket Mu Sekarang!
            </h3>
            <p class="text-lg md:text-xl text-gray-100 max-w-xl drop-shadow-md mb-8 leading-relaxed">
                Pesan tiket fast boat Anda sekarang dan nikmati perjalanan yang tak terlupakan.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('ticket') }}"
                    class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-6 py-3 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-ship mr-2"></i> Pesan Tiket Sekarang
                </a>
            </div>
        </div>
    </div>
</section>
