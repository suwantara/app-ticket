<!-- Booking Search Form -->
<div class="max-w-7xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl p-6">
        <form action="#" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4 items-end">

                <!-- Departure -->
                <div class="lg:col-span-1">
                    <label for="departure" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-ship mr-1 text-blue-600"></i> Keberangkatan
                    </label>
                    <select id="departure" name="departure" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        <option value="" selected>Pilih Pelabuhan</option>
                        <option value="sanur">Sanur, Bali</option>
                        <option value="padangbai">Padang Bai, Bali</option>
                        <option value="serangan">Serangan, Bali</option>
                        <option value="benoa">Benoa, Bali</option>
                    </select>
                </div>

                <!-- Destination -->
                <div class="lg:col-span-1">
                    <label for="destination" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-location-dot mr-1 text-red-500"></i> Tujuan
                    </label>
                    <select id="destination" name="destination" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        <option value="" selected>Pilih Tujuan</option>
                        <option value="nusa-penida">Nusa Penida</option>
                        <option value="nusa-lembongan">Nusa Lembongan</option>
                        <option value="gili-trawangan">Gili Trawangan</option>
                        <option value="gili-air">Gili Air</option>
                        <option value="lombok">Lombok</option>
                    </select>
                </div>

                <!-- Date Picker -->
                <div class="lg:col-span-1">
                    <label for="travel-date" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-regular fa-calendar mr-1 text-green-600"></i> Tanggal
                    </label>
                    <div class="relative">
                        <input datepicker datepicker-format="dd/mm/yyyy" type="text" id="travel-date" name="travel_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                            placeholder="Pilih Tanggal">
                    </div>
                </div>

                <!-- Adults -->
                <div class="lg:col-span-1">
                    <label for="adults" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-user mr-1 text-blue-600"></i> Dewasa
                    </label>
                    <select id="adults" name="adults" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        <option value="1" selected>1 Dewasa</option>
                        <option value="2">2 Dewasa</option>
                        <option value="3">3 Dewasa</option>
                        <option value="4">4 Dewasa</option>
                        <option value="5">5 Dewasa</option>
                        <option value="6">6 Dewasa</option>
                        <option value="7">7 Dewasa</option>
                        <option value="8">8 Dewasa</option>
                    </select>
                </div>

                <!-- Children -->
                <div class="lg:col-span-1">
                    <label for="children" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-child mr-1 text-orange-500"></i> Anak
                    </label>
                    <select id="children" name="children" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        <option value="0" selected>0 Anak</option>
                        <option value="1">1 Anak</option>
                        <option value="2">2 Anak</option>
                        <option value="3">3 Anak</option>
                        <option value="4">4 Anak</option>
                        <option value="5">5 Anak</option>
                    </select>
                </div>

                <!-- Infants -->
                <div class="lg:col-span-1">
                    <label for="infants" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-baby mr-1 text-pink-500"></i> Bayi
                    </label>
                    <select id="infants" name="infants" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        <option value="0" selected>0 Bayi</option>
                        <option value="1">1 Bayi</option>
                        <option value="2">2 Bayi</option>
                        <option value="3">3 Bayi</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div class="lg:col-span-1">
                    <button type="submit" class="w-full text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 p-3 text-center transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-magnifying-glass mr-2"></i> Cari Tiket
                    </button>
                </div>
            </div>
        </form>

        <!-- Quick Info -->
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex flex-wrap justify-center gap-6 text-sm text-gray-600">
                <span class="flex items-center">
                    <i class="fa-solid fa-check-circle text-green-500 mr-2"></i>
                    Pembayaran Aman
                </span>
                <span class="flex items-center">
                    <i class="fa-solid fa-ticket text-blue-500 mr-2"></i>
                    E-Ticket Instan
                </span>
                <span class="flex items-center">
                    <i class="fa-solid fa-headset text-purple-500 mr-2"></i>
                    Dukungan 24/7
                </span>
                <span class="flex items-center">
                    <i class="fa-solid fa-percent text-red-500 mr-2"></i>
                    Harga Terbaik
                </span>
            </div>
        </div>
    </div>
</div>
