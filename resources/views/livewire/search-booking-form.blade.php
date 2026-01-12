<!-- Booking Search Form -->
<div class="max-w-7xl mx-auto" id="booking">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl p-6">
        <!-- Flash Messages -->
        @if(session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <i class="fa-solid fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
        @endif

        <form wire:submit="search">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 items-end">

                <!-- Departure -->
                <div class="lg:col-span-1">
                    <label for="origin" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-ship mr-1 text-blue-600"></i> Keberangkatan
                    </label>
                    <select wire:model.live="origin" id="origin"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 cursor-pointer">
                        <option value="">Pilih Lokasi</option>
                        @php
                            $grouped = $destinations->groupBy('type');
                        @endphp
                        @if(isset($grouped['harbor']))
                        <optgroup label="🚢 Pelabuhan">
                            @foreach($grouped['harbor'] as $harbor)
                                <option value="{{ $harbor->id }}">{{ $harbor->name }}</option>
                            @endforeach
                        </optgroup>
                        @endif
                        @if(isset($grouped['island']))
                        <optgroup label="🏝️ Pulau">
                            @foreach($grouped['island'] as $island)
                                <option value="{{ $island->id }}">{{ $island->name }}</option>
                            @endforeach
                        </optgroup>
                        @endif
                    </select>
                    @error('origin') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Destination -->
                <div class="lg:col-span-1">
                    <label for="destination" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-location-dot mr-1 text-red-500"></i> Tujuan
                    </label>
                    <select wire:model="destination" id="destination"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 cursor-pointer">
                        <option value="">Pilih Tujuan</option>
                        @if(isset($grouped['island']))
                        <optgroup label="🏝️ Pulau">
                            @foreach($grouped['island'] as $island)
                                <option value="{{ $island->id }}" {{ $island->id == $origin ? 'disabled' : '' }}>
                                    {{ $island->name }}
                                </option>
                            @endforeach
                        </optgroup>
                        @endif
                        @if(isset($grouped['harbor']))
                        <optgroup label="🚢 Pelabuhan">
                            @foreach($grouped['harbor'] as $harbor)
                                <option value="{{ $harbor->id }}" {{ $harbor->id == $origin ? 'disabled' : '' }}>
                                    {{ $harbor->name }}
                                </option>
                            @endforeach
                        </optgroup>
                        @endif
                    </select>
                    @error('destination') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Date Picker -->
                <div class="lg:col-span-1">
                    <label for="date" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-regular fa-calendar mr-1 text-green-600"></i> Tanggal
                    </label>
                    <input type="date" wire:model="date" id="date" min="{{ date('Y-m-d') }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                    @error('date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Passengers -->
                <div class="lg:col-span-1">
                    <label for="passengers" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-users mr-1 text-blue-600"></i> Penumpang
                    </label>
                    <select wire:model="passengers" id="passengers"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 cursor-pointer">
                        @for($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}">{{ $i }} Orang</option>
                        @endfor
                    </select>
                </div>

                <!-- Return Trip Toggle -->
                <div class="lg:col-span-1">
                    <label for="returnTrip" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-rotate mr-1 text-purple-600"></i> Pulang-Pergi
                    </label>
                    <label class="relative inline-flex items-center cursor-pointer w-full bg-gray-50 border border-gray-300 rounded-lg p-3">
                        <input type="checkbox" wire:model.live="returnTrip" id="returnTrip" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[50%] after:-translate-y-1/2 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm text-gray-600">{{ $returnTrip ? 'Ya' : 'Tidak' }}</span>
                    </label>
                </div>

                <!-- Search Button -->
                <div class="lg:col-span-1">
                    <button type="submit"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-75 cursor-wait"
                            class="w-full text-white bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 p-3 text-center transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer">
                        <span wire:loading.remove>
                            <i class="fa-solid fa-magnifying-glass mr-2"></i> Cari Tiket
                        </span>
                        <span wire:loading>
                            <i class="fa-solid fa-spinner fa-spin mr-2"></i> Mencari...
                        </span>
                    </button>
                </div>
            </div>

            <!-- Return Date (shown when return trip is selected) -->
            @if($returnTrip)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div class="md:col-start-3">
                        <label for="returnDate" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="fa-regular fa-calendar-check mr-1 text-green-600"></i> Tanggal Pulang
                        </label>
                        <input type="date" wire:model="returnDate" id="returnDate" min="{{ $date }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        @error('returnDate') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            @endif
        </form>

        <!-- Search Results -->
        @if($showResults)
        <div class="mt-6 pt-6 border-t border-gray-200">
            <!-- Outbound Results -->
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fa-solid fa-ship mr-2 text-blue-600"></i>
                Jadwal Keberangkatan
                <span class="text-sm font-normal text-gray-500">
                    ({{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }})
                </span>
            </h3>

            @if(count($searchResults) > 0)
            <div class="space-y-4">
                @foreach($searchResults as $schedule)
                <div wire:click="selectSchedule({{ $schedule['id'] }}, false)"
                     class="bg-white rounded-xl border-2 cursor-pointer transition-all duration-200 overflow-hidden
                            {{ $selectedScheduleId == $schedule['id'] ? 'border-blue-500 ring-2 ring-blue-200 shadow-lg' : 'border-gray-200 hover:border-blue-300 hover:shadow-md' }}">
                    <div class="p-4">
                        <!-- Selected indicator -->
                        @if($selectedScheduleId == $schedule['id'])
                        <div class="flex items-center gap-2 mb-3 text-blue-600">
                            <i class="fa-solid fa-circle-check"></i>
                            <span class="text-sm font-semibold">Dipilih</span>
                        </div>
                        @endif

                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <!-- Ship & Operator Info -->
                            <div class="flex items-start gap-4">
                                <div class="bg-linear-to-br from-blue-500 to-blue-600 text-white p-3 rounded-xl">
                                    <i class="fa-solid fa-ship text-2xl"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $schedule['ship_name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $schedule['operator'] }}</div>
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach(array_slice($schedule['facilities'], 0, 4) as $facility)
                                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">{{ $facility }}</span>
                                        @endforeach
                                        @if(count($schedule['facilities']) > 4)
                                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">+{{ count($schedule['facilities']) - 4 }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Time & Route -->
                            <div class="flex items-center gap-3 lg:gap-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-800">{{ $schedule['departure_time'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $schedule['origin'] }}</div>
                                </div>
                                <div class="flex flex-col items-center px-4">
                                    <div class="text-xs text-gray-400">{{ $schedule['duration'] }}</div>
                                    <div class="flex items-center gap-1 my-1">
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                        <div class="w-16 h-0.5 bg-linear-to-r from-blue-500 to-green-500"></div>
                                        <i class="fa-solid fa-location-dot text-green-500"></i>
                                    </div>
                                    <div class="text-xs text-gray-400">Langsung</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-800">{{ $schedule['arrival_time'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $schedule['destination'] }}</div>
                                </div>
                            </div>

                            <!-- Price & Selection -->
                            <div class="flex items-center gap-4 lg:border-l lg:pl-6 lg:ml-auto">
                                <div class="text-right">
                                    <div class="text-xs text-gray-500">{{ $passengers }} penumpang</div>
                                    <div class="text-2xl font-bold text-blue-600">{{ $schedule['total_price_formatted'] }}</div>
                                    <div class="text-xs text-gray-400">
                                        <i class="fa-solid fa-chair mr-1"></i>{{ $schedule['available_seats'] }} kursi tersedia
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center
                                            {{ $selectedScheduleId == $schedule['id'] ? 'border-blue-500 bg-blue-500' : 'border-gray-300' }}">
                                    @if($selectedScheduleId == $schedule['id'])
                                    <i class="fa-solid fa-check text-white text-xs"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 bg-gray-50 rounded-xl">
                <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500 font-medium">Tidak ada jadwal tersedia untuk tanggal ini.</p>
                <p class="text-sm text-gray-400">Coba ubah lokasi atau tanggal perjalanan Anda.</p>
            </div>
            @endif

            <!-- Return Results (if round trip) -->
            @if($returnTrip && count($returnResults) > 0)
            <h3 class="text-lg font-bold text-gray-800 mb-4 mt-8">
                <i class="fa-solid fa-rotate-left mr-2 text-green-600"></i>
                Jadwal Kepulangan
                <span class="text-sm font-normal text-gray-500">
                    ({{ \Carbon\Carbon::parse($returnDate)->translatedFormat('l, d F Y') }})
                </span>
            </h3>

            <div class="space-y-4">
                @foreach($returnResults as $schedule)
                <div wire:click="selectSchedule({{ $schedule['id'] }}, true)"
                     class="bg-white rounded-xl border-2 cursor-pointer transition-all duration-200 overflow-hidden
                            {{ $selectedReturnScheduleId == $schedule['id'] ? 'border-green-500 ring-2 ring-green-200 shadow-lg' : 'border-gray-200 hover:border-green-300 hover:shadow-md' }}">
                    <div class="p-4">
                        <!-- Selected indicator -->
                        @if($selectedReturnScheduleId == $schedule['id'])
                        <div class="flex items-center gap-2 mb-3 text-green-600">
                            <i class="fa-solid fa-circle-check"></i>
                            <span class="text-sm font-semibold">Dipilih</span>
                        </div>
                        @endif

                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <!-- Ship & Operator Info -->
                            <div class="flex items-start gap-4">
                                <div class="bg-linear-to-br from-green-500 to-green-600 text-white p-3 rounded-xl">
                                    <i class="fa-solid fa-ship text-2xl"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $schedule['ship_name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $schedule['operator'] }}</div>
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach(array_slice($schedule['facilities'], 0, 4) as $facility)
                                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">{{ $facility }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Time & Route -->
                            <div class="flex items-center gap-3 lg:gap-6">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-800">{{ $schedule['departure_time'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $schedule['origin'] }}</div>
                                </div>
                                <div class="flex flex-col items-center px-4">
                                    <div class="text-xs text-gray-400">{{ $schedule['duration'] }}</div>
                                    <div class="flex items-center gap-1 my-1">
                                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                        <div class="w-16 h-0.5 bg-linear-to-r from-green-500 to-blue-500"></div>
                                        <i class="fa-solid fa-location-dot text-blue-500"></i>
                                    </div>
                                    <div class="text-xs text-gray-400">Langsung</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-800">{{ $schedule['arrival_time'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $schedule['destination'] }}</div>
                                </div>
                            </div>

                            <!-- Price & Selection -->
                            <div class="flex items-center gap-4 lg:border-l lg:pl-6 lg:ml-auto">
                                <div class="text-right">
                                    <div class="text-xs text-gray-500">{{ $passengers }} penumpang</div>
                                    <div class="text-2xl font-bold text-green-600">{{ $schedule['total_price_formatted'] }}</div>
                                    <div class="text-xs text-gray-400">
                                        <i class="fa-solid fa-chair mr-1"></i>{{ $schedule['available_seats'] }} kursi tersedia
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center
                                            {{ $selectedReturnScheduleId == $schedule['id'] ? 'border-green-500 bg-green-500' : 'border-gray-300' }}">
                                    @if($selectedReturnScheduleId == $schedule['id'])
                                    <i class="fa-solid fa-check text-white text-xs"></i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @elseif($returnTrip && count($returnResults) === 0)
            <div class="text-center py-8 bg-gray-50 rounded-xl mt-8">
                <i class="fa-solid fa-calendar-xmark text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500 font-medium">Tidak ada jadwal pulang tersedia.</p>
                <p class="text-sm text-gray-400">Coba ubah tanggal kepulangan Anda.</p>
            </div>
            @endif

            <!-- Proceed to Booking Button -->
            @if($selectedScheduleId || $selectedReturnScheduleId)
            <div class="mt-8 p-4 bg-linear-to-r from-blue-50 to-green-50 rounded-xl border border-blue-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="text-sm text-gray-600">Total Pembayaran</div>
                        <div class="text-3xl font-bold text-gray-800">
                            Rp {{ number_format($selectedTotal, 0, ',', '.') }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $passengers }} penumpang
                            @if($returnTrip && $selectedReturnScheduleId)
                            • Pulang-Pergi
                            @else
                            • Sekali Jalan
                            @endif
                        </div>
                    </div>
                    <button x-data
                            @click="confirmAction('Lanjutkan ke halaman pemesanan dengan total <strong>Rp {{ number_format($selectedTotal, 0, ',', '.') }}</strong>?', 'Konfirmasi Pemesanan').then(confirmed => { if(confirmed) $wire.proceedToBooking(); })"
                            wire:loading.attr="disabled"
                            class="bg-linear-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer">
                        <span wire:loading.remove wire:target="proceedToBooking">
                            <i class="fa-solid fa-arrow-right mr-2"></i> Lanjut ke Pemesanan
                        </span>
                        <span wire:loading wire:target="proceedToBooking">
                            <i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses...
                        </span>
                    </button>
                </div>
            </div>
            @endif
        </div>
        @endif

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
