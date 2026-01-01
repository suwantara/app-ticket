<!-- Booking Search Form -->
<div class="max-w-7xl mx-auto" id="booking">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl p-6">
        <form wire:submit="search">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 items-end">

                <!-- Departure -->
                <div class="lg:col-span-1">
                    <label for="origin" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-ship mr-1 text-blue-600"></i> Keberangkatan
                    </label>
                    <select wire:model.live="origin" id="origin" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
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
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
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
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                        @for($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}">{{ $i }} Orang</option>
                        @endfor
                    </select>
                </div>

                <!-- Return Trip Toggle -->
                <div class="lg:col-span-1">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-rotate mr-1 text-purple-600"></i> Pulang-Pergi
                    </label>
                    <label class="relative inline-flex items-center cursor-pointer w-full bg-gray-50 border border-gray-300 rounded-lg p-3">
                        <input type="checkbox" wire:model.live="returnTrip" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[50%] after:-translate-y-1/2 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm text-gray-600">{{ $returnTrip ? 'Ya' : 'Tidak' }}</span>
                    </label>
                </div>

                <!-- Search Button -->
                <div class="lg:col-span-1">
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-75 cursor-wait"
                            class="w-full text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 p-3 text-center transition-all duration-200 shadow-lg hover:shadow-xl">
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
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fa-solid fa-list mr-2 text-blue-600"></i> Hasil Pencarian
            </h3>
            
            @if(count($searchResults) > 0)
            <div class="space-y-3">
                @foreach($searchResults as $route)
                <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors border border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $route['code'] }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2 font-medium text-gray-800">
                                    <span>{{ $route['origin'] }}</span>
                                    <i class="fa-solid fa-arrow-right text-gray-400"></i>
                                    <span>{{ $route['destination'] }}</span>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="fa-regular fa-clock mr-1"></i> {{ $route['duration'] }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <div class="text-xs text-gray-500">{{ $passengers }} penumpang</div>
                                <div class="text-xl font-bold text-blue-600">
                                    Rp {{ number_format($route['total_price'], 0, ',', '.') }}
                                </div>
                            </div>
                            <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                                Pilih
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i class="fa-solid fa-ship text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Tidak ada rute tersedia untuk pencarian ini.</p>
                <p class="text-sm text-gray-400">Coba ubah lokasi atau tanggal perjalanan Anda.</p>
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
