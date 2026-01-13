<!-- Booking Search Form -->
<div class="max-w-5xl mx-auto" id="booking">
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8">
        <!-- Flash Messages -->
        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl flex items-center gap-3">
                <i class="fa-solid fa-exclamation-circle text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form wire:submit="search">
            <!-- Trip Type Toggle -->
            <div class="mb-6">
                <div class="inline-flex rounded-xl bg-gray-100 p-1">
                    <button type="button" wire:click="$set('returnTrip', false)"
                        class="px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center gap-2
                                   {{ !$returnTrip ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        <i class="fa-solid fa-arrow-right"></i>
                        Sekali Jalan
                    </button>
                    <button type="button" wire:click="$set('returnTrip', true)"
                        class="px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center gap-2
                                   {{ $returnTrip ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        <i class="fa-solid fa-rotate"></i>
                        Pulang Pergi
                    </button>
                </div>
            </div>

            <div class="flex flex-wrap items-end gap-4">
                <!-- Departure -->
                <div class="flex-1 min-w-[180px]">
                    <label for="origin" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-ship mr-1 text-blue-600"></i> Keberangkatan
                    </label>
                    <select wire:model.live="origin" id="origin"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-4 cursor-pointer">
                        <option value="">Pilih Lokasi</option>
                        @php
                            $grouped = $destinations->groupBy('type');
                        @endphp
                        @if (isset($grouped['harbor']))
                            <optgroup label="🚢 Pelabuhan">
                                @foreach ($grouped['harbor'] as $harbor)
                                    <option value="{{ $harbor->id }}">{{ $harbor->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if (isset($grouped['island']))
                            <optgroup label="🏝️ Pulau">
                                @foreach ($grouped['island'] as $island)
                                    <option value="{{ $island->id }}">{{ $island->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                    @error('origin')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Destination -->
                <div class="flex-1 min-w-[180px]">
                    <label for="destination" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-location-dot mr-1 text-red-500"></i> Tujuan
                    </label>
                    <select wire:model="destination" id="destination"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-4 cursor-pointer">
                        <option value="">Pilih Tujuan</option>
                        @if (isset($grouped['island']))
                            <optgroup label="🏝️ Pulau">
                                @foreach ($grouped['island'] as $island)
                                    <option value="{{ $island->id }}" {{ $island->id == $origin ? 'disabled' : '' }}>
                                        {{ $island->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if (isset($grouped['harbor']))
                            <optgroup label="🚢 Pelabuhan">
                                @foreach ($grouped['harbor'] as $harbor)
                                    <option value="{{ $harbor->id }}"
                                        {{ $harbor->id == $origin ? 'disabled' : '' }}>
                                        {{ $harbor->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                    @error('destination')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Date Picker -->
                <div class="flex-1 min-w-[150px]">
                    <label for="date" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-regular fa-calendar mr-1 text-green-600"></i>
                        {{ $returnTrip ? 'Tanggal Pergi' : 'Tanggal' }}
                    </label>
                    <input type="date" wire:model.live="date" id="date" min="{{ date('Y-m-d') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-4">
                    @error('date')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Return Date (shown when return trip) -->
                @if ($returnTrip)
                    <div class="flex-1 min-w-[150px]">
                        <label for="returnDate" class="block mb-2 text-sm font-semibold text-gray-700">
                            <i class="fa-regular fa-calendar-check mr-1 text-purple-600"></i> Tanggal Pulang
                        </label>
                        <input type="date" wire:model.live="returnDate" id="returnDate" min="{{ $date }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-4">
                        @error('returnDate')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <!-- Passengers -->
                <div class="w-[140px] shrink-0">
                    <label for="passengers" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-users mr-1 text-blue-600"></i> Penumpang
                    </label>
                    <div class="flex items-center bg-gray-50 border border-gray-300 rounded-xl overflow-hidden">
                        <button type="button" wire:click="$set('passengers', Math.max(1, {{ $passengers }} - 1))"
                            class="px-3 py-4 text-gray-600 hover:bg-gray-200 transition-colors">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <input type="number" wire:model.live="passengers" id="passengers" min="1" max="20"
                            class="w-full text-center bg-transparent border-0 text-gray-900 text-lg font-bold focus:ring-0 p-0">
                        <button type="button" wire:click="$set('passengers', Math.min(20, {{ $passengers }} + 1))"
                            class="px-3 py-4 text-gray-600 hover:bg-gray-200 transition-colors">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    @error('passengers')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Search Button -->
                <div class="shrink-0">
                    <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                        class="text-white bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-base px-8 py-4 text-center transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer whitespace-nowrap">
                        <span wire:loading.remove>
                            <i class="fa-solid fa-magnifying-glass mr-2"></i> Cari
                        </span>
                        <span wire:loading>
                            <i class="fa-solid fa-spinner fa-spin mr-2"></i> ...
                        </span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Quick Info -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex flex-wrap justify-center gap-6 text-sm text-gray-600">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-check-circle text-green-500"></i>
                    Pembayaran Aman
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-ticket text-blue-500"></i>
                    E-Ticket Instan
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-headset text-purple-500"></i>
                    Dukungan 24/7
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-percent text-red-500"></i>
                    Harga Terbaik
                </span>
            </div>
        </div>
    </div>
</div>
