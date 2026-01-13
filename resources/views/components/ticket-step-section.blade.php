{{-- Cara Pesan Tiket Section --}}
<section class="py-16 bg-neutral-primary">
    <div class="container mx-auto px-4">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Cara Pesan Tiket</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Pesan tiket fast boat dalam 4 langkah mudah</p>
        </div>

        {{-- Steps Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="relative group">
                <div
                    class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl justify-items-center transition-all duration-300 h-full border border-gray-100 text-center">
                    {{-- Icon --}}
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-route text-3xl text-blue-500"></i>
                    </div>
                    {{-- Content --}}
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Pilih Rute</h3>
                    <p class="text-gray-600">Tentukan pelabuhan keberangkatan dan tujuan perjalanan Anda</p>
                </div>
            </div>

            {{-- Step 2: Tentukan Jadwal --}}
            <div class="relative group">
                <div
                    class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl justify-items-center transition-all duration-300 h-full border border-gray-100 text-center">
                    {{-- Icon --}}
                    <div class="w-16 h-16 bg-cyan-50 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-calendar text-3xl text-cyan-500"></i>
                    </div>
                    {{-- Content --}}
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Tentukan Jadwal</h3>
                    <p class="text-gray-600">Pilih tanggal keberangkatan dan jam yang sesuai dengan rencana Anda
                    </p>
                </div>
            </div>

            {{-- Step 3: Isi Data --}}
            <div class="relative group">
                <div
                    class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl justify-items-center transition-all duration-300 h-full border border-gray-100 text-center">
                    {{-- Icon --}}
                    <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-user text-3xl text-green-500"></i>
                    </div>
                    {{-- Content --}}
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Isi Data</h3>
                    <p class="text-gray-600">Lengkapi data penumpang sesuai identitas yang berlaku</p>
                </div>
            </div>

            {{-- Step 4: Bayar & Terima E-Ticket --}}
            <div class="relative group">
                <div
                    class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl justify-items-center transition-all duration-300 h-full border border-gray-100 text-center">
                    {{-- Icon --}}
                    <div class="w-16 h-16 bg-yellow-50 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-money-bill text-3xl text-yellow-500"></i>
                    </div>
                    {{-- Content --}}
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Terima E-Ticket</h3>
                    <p class="text-gray-600">Bayar dengan berbagai metode dan terima e-ticket langsung bentuk PDF</p>
                </div>
            </div>
        </div>
    </div>
</section>
