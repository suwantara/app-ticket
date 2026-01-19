<div>
    {{-- Jadwal & Rute Populer Hari Ini --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                            <i class="fa-solid fa-circle text-[8px] mr-1"></i> HARI INI
                        </span>
                        <span class="text-gray-500 text-sm">{{ $today->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Jadwal & Rute Populer</h2>
                    <p class="text-gray-600 mt-2">Jadwal keberangkatan fast boat tersedia hari ini</p>
                </div>
                <a href="{{ route('ticket') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                    <span>Lihat Semua Jadwal</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            {{-- Filter Section --}}
            <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-100">
                <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                    {{-- Origin Filter --}}
                    <div class="flex-1">
                        <label for="originId" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fa-solid fa-location-dot text-blue-600 mr-1"></i>
                            Pelabuhan Asal
                        </label>
                        <select wire:model.live="originId" id="originId"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Semua Pelabuhan</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->id }}" @disabled($destination->id === $destinationId)>
                                    {{ $destination->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Destination Filter --}}
                    <div class="flex-1">
                        <label for="destinationId" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fa-solid fa-flag-checkered text-green-600 mr-1"></i>
                            Pelabuhan Tujuan
                        </label>
                        <select wire:model.live="destinationId" id="destinationId"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">Semua Tujuan</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->id }}" @disabled($destination->id === $originId)>
                                    {{ $destination->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sort Filter --}}
                    <div class="flex-1">
                        <label for="sortBy" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fa-solid fa-arrow-up-wide-short text-purple-600 mr-1"></i>
                            Urutkan
                        </label>
                        <select wire:model.live="sortBy" id="sortBy"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="time_asc">Waktu (Paling Awal)</option>
                            <option value="price_asc">Harga (Termurah)</option>
                            <option value="price_desc">Harga (Termahal)</option>
                        </select>
                    </div>

                    {{-- Reset Button --}}
                    <div class="flex items-end">
                        <button wire:click="resetFilters" type="button"
                            class="relative inline-flex items-center gap-2 px-5 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-xl transition-all duration-300"
                            @disabled($activeFilterCount === 0)>
                            <i class="fa-solid fa-rotate-left"></i>
                            <span class="hidden sm:inline">Reset</span>
                            @if ($activeFilterCount > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                                    {{ $activeFilterCount }}
                                </span>
                            @endif
                        </button>
                    </div>
                </div>

                {{-- Loading Indicator --}}
                <div wire:loading wire:target="originId, destinationId, sortBy, resetFilters"
                    class="mt-4 flex items-center gap-2 text-blue-600">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span class="text-sm">Memuat jadwal...</span>
                </div>
            </div>

            {{-- Loading Overlay for Schedule Grid --}}
            <div wire:loading.class="opacity-50 pointer-events-none"
                wire:target="originId, destinationId, sortBy, resetFilters" class="transition-opacity duration-200">
                @if ($schedules->count() > 0)
                    {{-- Schedule Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($schedules as $schedule)
                            <div
                                class="bg-blue-900 rounded-2xl p-5 border border-blue-900 hover:border-blue-200 hover:shadow-lg transition-all duration-300 group">
                                {{-- Route Header --}}
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center justify-between w-full">
                                        {{-- Origin --}}
                                        <div class="text-center">
                                            <p class="text-lg font-bold text-white">
                                                {{ $schedule->route->origin->name ?? 'Origin' }}</p>
                                            <p class="text-xs text-gray-200">Berangkat</p>
                                        </div>
                                        {{-- Arrow --}}
                                        <div class="flex flex-col items-center px-2">
                                            <i
                                                class="fa-solid fa-arrow-right text-yellow-400 group-hover:translate-x-1 transition-transform"></i>
                                            <span
                                                class="text-xs text-gray-200 mt-1">{{ $schedule->route->formatted_duration ?? '~' }}</span>
                                        </div>
                                        {{-- Destination --}}
                                        <div class="text-center">
                                            <p class="text-lg font-bold text-white">
                                                {{ $schedule->route->destination->name ?? 'Destination' }}</p>
                                            <p class="text-xs text-gray-200">Tiba</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Schedule Details --}}
                                <div class="flex items-center justify-between py-3 border-t border-gray-200">
                                    {{-- Time --}}
                                    <div class="flex items-center gap-2">
                                        <div class="bg-blue-100 text-blue-700 p-2 rounded-full">
                                            <i class="fa-regular fa-clock text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-lg font-bold text-white">
                                                {{ $schedule->departure_time_formatted }}</p>
                                            <p class="text-xs text-gray-200">Keberangkatan</p>
                                        </div>
                                    </div>

                                    {{-- Price --}}
                                    <div class="text-right">
                                        <p class="text-xs text-gray-200">Mulai dari</p>
                                        <p class="text-xl font-bold text-yellow-400">{{ $schedule->price_formatted }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Ship Info & CTA --}}
                                <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-ship text-gray-200"></i>
                                        <span
                                            class="text-sm text-gray-200">{{ $schedule->ship->name ?? 'Fast Boat' }}</span>
                                    </div>
                                    <a href="{{ route('ticket', ['origin' => $schedule->route->origin_id, 'destination' => $schedule->route->destination_id]) }}"
                                        class="inline-flex items-center gap-1 px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-black text-sm font-semibold rounded-lg transition-all duration-300">
                                        Pesan
                                        <i class="fa-solid fa-arrow-right text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-12 bg-blue-900 rounded-2xl">
                        <div class="text-gray-200 mb-4">
                            <i class="fa-regular fa-calendar-xmark text-6xl"></i>
                        </div>
                        @if ($activeFilterCount > 0)
                            <h3 class="text-xl font-semibold text-gray-200 mb-2">Tidak ada jadwal dengan filter ini</h3>
                            <p class="text-gray-200 mb-6">Coba ubah filter atau reset untuk melihat semua jadwal</p>
                            <button wire:click="resetFilters"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-black font-semibold rounded-xl transition-all duration-300">
                                <i class="fa-solid fa-rotate-left"></i>
                                <span>Reset Filter</span>
                            </button>
                        @else
                            <h3 class="text-xl font-semibold text-gray-200 mb-2">Tidak ada jadwal tersedia hari ini</h3>
                            <p class="text-gray-200 mb-6">Silakan cek jadwal untuk tanggal lain</p>
                            <a href="{{ route('booking.form') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300">
                                <span>Cari Jadwal Lain</span>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
