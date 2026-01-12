<x-layouts.app :title="$page->meta_title ?? 'Hubungi Kami'">
    {{-- Page Header --}}
    <section class="bg-linear-to-r from-blue-600 to-blue-800 py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                {{ $page->title }}
            </h1>
            @if($page->meta_description)
                <p class="text-lg text-blue-100 max-w-2xl mx-auto">
                    {{ $page->meta_description }}
                </p>
            @endif
        </div>
    </section>

    {{-- Contact Section --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                {{-- Contact Info --}}
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h2>

                    <div class="space-y-6">
                        {{-- Address --}}
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-location-dot text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Alamat</h3>
                                <p class="text-gray-600">Jl. Raya Kuta No. 123, Bali, Indonesia</p>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-phone text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Telepon</h3>
                                <p class="text-gray-600">+62 361 123456</p>
                            </div>
                        </div>

                        {{-- WhatsApp --}}
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-brands fa-whatsapp text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">WhatsApp</h3>
                                <p class="text-gray-600">+62 812 3456 7890</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-envelope text-red-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Email</h3>
                                <p class="text-gray-600">info@fastboatticket.com</p>
                            </div>
                        </div>
                    </div>

                    {{-- Operating Hours --}}
                    <div class="mt-8 p-6 bg-white rounded-xl shadow-lg">
                        <h3 class="font-semibold text-gray-800 mb-4">
                            <i class="fa-regular fa-clock mr-2 text-blue-600"></i>
                            Jam Operasional
                        </h3>
                        <div class="space-y-2 text-gray-600">
                            <div class="flex justify-between">
                                <span>Senin - Jumat</span>
                                <span class="font-medium">08:00 - 20:00 WITA</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Sabtu - Minggu</span>
                                <span class="font-medium">09:00 - 18:00 WITA</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Hari Libur</span>
                                <span class="font-medium">09:00 - 15:00 WITA</span>
                            </div>
                        </div>
                    </div>

                    {{-- Social Media --}}
                    <div class="mt-8">
                        <h3 class="font-semibold text-gray-800 mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-pink-500 text-white rounded-lg flex items-center justify-center hover:bg-pink-600 transition-colors">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 bg-sky-500 text-white rounded-lg flex items-center justify-center hover:bg-sky-600 transition-colors">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div>
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>

                        <form action="#" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Masukkan nama Anda" required>
                            </div>

                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="email@example.com" required>
                            </div>

                            <div>
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="+62 xxx xxxx xxxx">
                            </div>

                            <div>
                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-700">Subjek</label>
                                <select id="subject" name="subject" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                                    <option value="">Pilih Subjek</option>
                                    <option value="booking">Pertanyaan Pemesanan</option>
                                    <option value="payment">Pembayaran</option>
                                    <option value="refund">Refund/Pembatalan</option>
                                    <option value="partnership">Kerjasama</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Pesan</label>
                                <textarea id="message" name="message" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Tulis pesan Anda di sini..." required></textarea>
                            </div>

                            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-4 text-center transition-colors">
                                <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CMS Content --}}
    @if($page->content)
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

    {{-- Map Section --}}
    <section class="h-96 bg-gray-300">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3943.8969033990835!2d115.16797631478584!3d-8.722935493721847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2469e79b0a0b1%3A0x6a8c76d6e8c6a97a!2sKuta%2C%20Badung%20Regency%2C%20Bali!5e0!3m2!1sen!2sid!4v1234567890"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Lokasi Kantor Kami">
        </iframe>
    </section>
</x-layouts.app>
