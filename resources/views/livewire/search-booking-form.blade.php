<!-- Booking Search Form -->
<div class="max-w-7xl mx-auto px-4 lg:px-0 relative z-30" id="booking">
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-md p-6 lg:p-8">
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
                                   {{ !$returnTrip ? 'bg-yellow-400 text-black shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        <i class="fa-solid fa-arrow-right"></i>
                        Sekali Jalan
                    </button>
                    <button type="button" wire:click="$set('returnTrip', true)"
                        class="px-6 py-3 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center gap-2
                                   {{ $returnTrip ? 'bg-yellow-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-200' }}">
                        <i class="fa-solid fa-rotate"></i>
                        Pulang Pergi
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 items-end">
                <!-- Departure -->
                <div class="sm:col-span-1 lg:col-span-1" x-data="{ open: false }">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-ship mr-1 text-blue-600"></i> Keberangkatan
                    </label>
                    <div class="relative">
                        <button @click="open = !open" @click.away="open = false" type="button"
                            class="flex items-center justify-between w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 p-4 cursor-pointer text-left">
                            <span class="truncate">
                                @if ($origin)
                                    {{ $destinations->flatten()->firstWhere('id', $origin)?->name ?? 'Pilih Lokasi' }}
                                @else
                                    Pilih Lokasi
                                @endif
                            </span>
                            <i class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': open }"></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-xl border border-gray-100 max-h-60 overflow-y-auto"
                            style="display: none;">
                            <ul class="py-2 text-sm text-gray-700">
                                @php
                                    $grouped = $destinations->groupBy('type');
                                @endphp
                                @if (isset($grouped['harbor']))
                                    <li
                                        class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider bg-gray-50">
                                        🚢 Pelabuhan
                                    </li>
                                    @foreach ($grouped['harbor'] as $harbor)
                                        <li>
                                            <button type="button"
                                                @click="$wire.set('origin', '{{ $harbor->id }}'); open = false"
                                                class="w-full text-left px-4 py-3 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ $origin == $harbor->id ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                                                {{ $harbor->name }}
                                            </button>
                                        </li>
                                    @endforeach
                                @endif
                                @if (isset($grouped['island']))
                                    <li
                                        class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider bg-gray-50 border-t border-gray-100 mt-2">
                                        🏝️ Pulau
                                    </li>
                                    @foreach ($grouped['island'] as $island)
                                        <li>
                                            <button type="button"
                                                @click="$wire.set('origin', '{{ $island->id }}'); open = false"
                                                class="w-full text-left px-4 py-3 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ $origin == $island->id ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                                                {{ $island->name }}
                                            </button>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    @error('origin')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Destination -->
                <div class="sm:col-span-1 lg:col-span-1" x-data="{ open: false }">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-location-dot mr-1 text-red-500"></i> Tujuan
                    </label>
                    <div class="relative">
                        <button @click="open = !open" @click.away="open = false" type="button"
                            class="flex items-center justify-between w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 p-4 cursor-pointer text-left">
                            <span class="truncate">
                                @if ($destination)
                                    {{ $destinations->flatten()->firstWhere('id', $destination)?->name ?? 'Pilih Tujuan' }}
                                @else
                                    Pilih Tujuan
                                @endif
                            </span>
                            <i class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-200"
                                :class="{ 'rotate-180': open }"></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-xl border border-gray-100 max-h-60 overflow-y-auto"
                            style="display: none;">
                            <ul class="py-2 text-sm text-gray-700">
                                @if (isset($grouped['island']))
                                    <li
                                        class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider bg-gray-50">
                                        🏝️ Pulau
                                    </li>
                                    @foreach ($grouped['island'] as $island)
                                        @if ($island->id != $origin)
                                            <li>
                                                <button type="button"
                                                    @click="$wire.set('destination', '{{ $island->id }}'); open = false"
                                                    class="w-full text-left px-4 py-3 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ $destination == $island->id ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                                                    {{ $island->name }}
                                                </button>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                                @if (isset($grouped['harbor']))
                                    <li
                                        class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider bg-gray-50 border-t border-gray-100 mt-2">
                                        🚢 Pelabuhan
                                    </li>
                                    @foreach ($grouped['harbor'] as $harbor)
                                        @if ($harbor->id != $origin)
                                            <li>
                                                <button type="button"
                                                    @click="$wire.set('destination', '{{ $harbor->id }}'); open = false"
                                                    class="w-full text-left px-4 py-3 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ $destination == $harbor->id ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">
                                                    {{ $harbor->name }}
                                                </button>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    @error('destination')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Date Picker -->
                <div class="sm:col-span-1 lg:col-span-1">
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

                @if ($returnTrip)
                    <div class="sm:col-span-1 lg:col-span-1">
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
                <div class="sm:col-span-1 lg:col-span-1">
                    <label for="passengers" class="block mb-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-users mr-1 text-blue-600"></i> Penumpang
                    </label>
                    <div class="flex items-center bg-gray-50 border border-gray-300 rounded-xl overflow-hidden">
                        <button type="button" wire:click="$set('passengers', Math.max(1, {{ $passengers }} - 1))"
                            class="px-2 py-3 text-gray-600 hover:bg-gray-200 transition-colors">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <input type="number" wire:model.live="passengers" id="passengers" min="1"
                            max="20"
                            class="w-full text-center bg-transparent border-0 text-gray-900 text-base font-semibold focus:ring-0 p-0">
                        <button type="button" wire:click="$set('passengers', Math.min(20, {{ $passengers }} + 1))"
                            class="px-2 py-3 text-gray-600 hover:bg-gray-200 transition-colors">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    @error('passengers')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Search Button -->
                <div class="sm:col-span-2 lg:col-span-1">
                    <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-wait"
                        class="w-full text-white bg-blue-900 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-base px-8 py-4 text-center transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer whitespace-nowrap">
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
