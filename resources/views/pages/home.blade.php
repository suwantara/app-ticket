<x-layouts.app :title="$page->meta_title ?? 'Home'">
    {{-- Hero Section with Booking Search --}}
    <x-hero-section />

    {{-- CMS Content Section --}}
    @if($page && $page->content)
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <article class="prose prose-lg max-w-none prose-headings:text-gray-800 prose-p:text-gray-600 prose-a:text-blue-600 hover:prose-a:text-blue-800 prose-ul:text-gray-600 prose-ol:text-gray-600 prose-strong:text-gray-700">
                        {!! $page->content !!}
                    </article>
                </div>
            </div>
        </section>
    @endif

    {{-- Features Section --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Mengapa Memilih Kami?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Nikmati pengalaman pemesanan tiket fast boat yang mudah, aman, dan terpercaya</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-ticket text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">E-Ticket Instan</h3>
                    <p class="text-gray-600">Tiket digital langsung dikirim ke email Anda setelah pembayaran</p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-shield-halved text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Pembayaran Aman</h3>
                    <p class="text-gray-600">Transaksi terjamin dengan berbagai metode pembayaran</p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-tags text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Harga Terbaik</h3>
                    <p class="text-gray-600">Dapatkan harga kompetitif dengan promo menarik</p>
                </div>

                {{-- Feature 4 --}}
                <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-headset text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Support 24/7</h3>
                    <p class="text-gray-600">Tim customer service siap membantu kapan saja</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Destinations Preview --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Destinasi Populer</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Jelajahi keindahan pulau-pulau eksotis di Indonesia</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Destination 1 --}}
                <div class="group relative overflow-hidden rounded-2xl shadow-lg">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=800"
                         alt="Nusa Penida"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="text-xl font-bold text-white mb-1">Nusa Penida</h3>
                        <p class="text-gray-200 text-sm">Dari Sanur, Bali</p>
                    </div>
                </div>

                {{-- Destination 2 --}}
                <div class="group relative overflow-hidden rounded-2xl shadow-lg">
                    <img src="https://images.unsplash.com/photo-1573790387438-4da905039392?q=80&w=800"
                         alt="Gili Trawangan"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="text-xl font-bold text-white mb-1">Gili Trawangan</h3>
                        <p class="text-gray-200 text-sm">Dari Padang Bai, Bali</p>
                    </div>
                </div>

                {{-- Destination 3 --}}
                <div class="group relative overflow-hidden rounded-2xl shadow-lg">
                    <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?q=80&w=800"
                         alt="Lombok"
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="text-xl font-bold text-white mb-1">Lombok</h3>
                        <p class="text-gray-200 text-sm">Dari Benoa, Bali</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Untuk Petualangan?</h2>
            <p class="text-blue-100 mb-8 max-w-2xl mx-auto">Pesan tiket fast boat Anda sekarang dan nikmati perjalanan yang tak terlupakan</p>
            <a href="{{ route('ticket') }}" class="inline-block bg-white text-blue-600 font-semibold px-8 py-4 rounded-lg hover:bg-gray-100 transition-colors shadow-lg cursor-pointer">
                <i class="fa-solid fa-ship mr-2"></i> Pesan Sekarang
            </a>
        </div>
    </section>
</x-layouts.app>
