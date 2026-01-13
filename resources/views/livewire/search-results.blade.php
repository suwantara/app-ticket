<!-- Search Results Component -->
<div>
    @if ($showResults)
        <div class="max-w-5xl mx-auto mt-8" id="search-results">
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden">

                <!-- Flash Messages -->
                @if (session()->has('error'))
                    <div
                        class="m-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl flex items-center gap-3">
                        <i class="fa-solid fa-exclamation-circle text-xl"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Outbound Results -->
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-ship text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <span>Jadwal Keberangkatan</span>
                            <span class="text-sm font-normal text-gray-500 ml-2">
                                {{ \Carbon\Carbon::parse($date)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </h3>

                    @if (count($searchResults) > 0)
                        <div class="space-y-2">
                            @foreach ($searchResults as $schedule)
                                <div wire:click="selectSchedule({{ $schedule['id'] }}, false)"
                                    class="flex items-center gap-4 p-4 rounded-xl cursor-pointer transition-all duration-200
                                {{ $selectedScheduleId == $schedule['id']
                                    ? 'bg-blue-50 border-2 border-blue-500 shadow-sm'
                                    : 'bg-gray-50 border-2 border-transparent hover:bg-blue-50/50 hover:border-blue-200' }}">

                                    <!-- Selection Radio -->
                                    <div class="shrink-0">
                                        <div
                                            class="w-5 h-5 rounded-full border-2 flex items-center justify-center
                                        {{ $selectedScheduleId == $schedule['id'] ? 'border-blue-500 bg-blue-500' : 'border-gray-300' }}">
                                            @if ($selectedScheduleId == $schedule['id'])
                                                <i class="fa-solid fa-check text-white text-xs"></i>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Ship Info -->
                                    <div class="min-w-0 flex-1">
                                        <div class="font-semibold text-gray-800">{{ $schedule['ship_name'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $schedule['operator'] }}</div>
                                    </div>

                                    <!-- Time -->
                                    <div class="text-center shrink-0">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="font-bold text-gray-800">{{ $schedule['departure_time'] }}</span>
                                            <i class="fa-solid fa-arrow-right text-gray-400 text-xs"></i>
                                            <span class="font-bold text-gray-800">{{ $schedule['arrival_time'] }}</span>
                                        </div>
                                        <div class="text-xs text-gray-400">{{ $schedule['duration'] }}</div>
                                    </div>

                                    <!-- Seats -->
                                    <div class="text-center shrink-0 hidden sm:block">
                                        <div class="text-sm text-gray-500">
                                            <i class="fa-solid fa-chair mr-1"></i>{{ $schedule['available_seats'] }}
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="text-right shrink-0">
                                        <div class="font-bold text-blue-600">{{ $schedule['total_price_formatted'] }}
                                        </div>
                                        <div class="text-xs text-gray-400">{{ $passengers }} org</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-xl">
                            <i class="fa-solid fa-calendar-xmark text-3xl text-gray-300 mb-2"></i>
                            <p class="text-gray-500 font-medium">Tidak ada jadwal tersedia</p>
                        </div>
                    @endif
                </div>

                <!-- Return Results -->
                @if ($returnTrip)
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-rotate-left text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <span>Jadwal Kepulangan</span>
                                <span class="text-sm font-normal text-gray-500 ml-2">
                                    {{ \Carbon\Carbon::parse($returnDate)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </h3>

                        @if (count($returnResults) > 0)
                            <div class="space-y-2">
                                @foreach ($returnResults as $schedule)
                                    <div wire:click="selectSchedule({{ $schedule['id'] }}, true)"
                                        class="flex items-center gap-4 p-4 rounded-xl cursor-pointer transition-all duration-200
                                {{ $selectedReturnScheduleId == $schedule['id']
                                    ? 'bg-green-50 border-2 border-green-500 shadow-sm'
                                    : 'bg-gray-50 border-2 border-transparent hover:bg-green-50/50 hover:border-green-200' }}">

                                        <!-- Selection Radio -->
                                        <div class="shrink-0">
                                            <div
                                                class="w-5 h-5 rounded-full border-2 flex items-center justify-center
                                        {{ $selectedReturnScheduleId == $schedule['id'] ? 'border-green-500 bg-green-500' : 'border-gray-300' }}">
                                                @if ($selectedReturnScheduleId == $schedule['id'])
                                                    <i class="fa-solid fa-check text-white text-xs"></i>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Ship Info -->
                                        <div class="min-w-0 flex-1">
                                            <div class="font-semibold text-gray-800">{{ $schedule['ship_name'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $schedule['operator'] }}</div>
                                        </div>

                                        <!-- Time -->
                                        <div class="text-center shrink-0">
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="font-bold text-gray-800">{{ $schedule['departure_time'] }}</span>
                                                <i class="fa-solid fa-arrow-right text-gray-400 text-xs"></i>
                                                <span
                                                    class="font-bold text-gray-800">{{ $schedule['arrival_time'] }}</span>
                                            </div>
                                            <div class="text-xs text-gray-400">{{ $schedule['duration'] }}</div>
                                        </div>

                                        <!-- Seats -->
                                        <div class="text-center shrink-0 hidden sm:block">
                                            <div class="text-sm text-gray-500">
                                                <i
                                                    class="fa-solid fa-chair mr-1"></i>{{ $schedule['available_seats'] }}
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="text-right shrink-0">
                                            <div class="font-bold text-green-600">
                                                {{ $schedule['total_price_formatted'] }}</div>
                                            <div class="text-xs text-gray-400">{{ $passengers }} org</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-xl">
                                <i class="fa-solid fa-calendar-xmark text-3xl text-gray-300 mb-2"></i>
                                <p class="text-gray-500 font-medium">Tidak ada jadwal pulang tersedia</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Booking Summary -->
                @if ($selectedScheduleId)
                    @php
                        $selectedOutbound = collect($searchResults)->firstWhere('id', $selectedScheduleId);
                        $selectedReturn = $selectedReturnScheduleId
                            ? collect($returnResults)->firstWhere('id', $selectedReturnScheduleId)
                            : null;
                    @endphp
                    <div class="p-6 bg-linear-to-r from-blue-50 to-green-50">
                        <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-clipboard-list text-blue-600"></i>
                            Ringkasan Pemesanan
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Outbound Summary -->
                            <div class="bg-white rounded-xl p-4 border border-blue-100">
                                <div class="flex items-center gap-2 text-blue-600 font-semibold text-sm mb-2">
                                    <i class="fa-solid fa-arrow-right"></i>
                                    Pergi
                                </div>
                                <div class="font-bold text-gray-800">{{ $selectedOutbound['origin'] }} →
                                    {{ $selectedOutbound['destination'] }}</div>
                                <div class="text-sm text-gray-600 mt-1">
                                    <i class="fa-solid fa-ship mr-1"></i>{{ $selectedOutbound['ship_name'] }}
                                    ({{ $selectedOutbound['operator'] }})
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    <i
                                        class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d M Y') }}
                                    <span class="mx-1">•</span>
                                    <i class="fa-regular fa-clock mr-1"></i>{{ $selectedOutbound['departure_time'] }} -
                                    {{ $selectedOutbound['arrival_time'] }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="fa-solid fa-users mr-1"></i>{{ $passengers }} penumpang
                                </div>
                                <div class="mt-2 font-bold text-blue-600">
                                    {{ $selectedOutbound['total_price_formatted'] }}</div>
                            </div>

                            <!-- Return Summary -->
                            @if ($returnTrip && $selectedReturn)
                                <div class="bg-white rounded-xl p-4 border border-green-100">
                                    <div class="flex items-center gap-2 text-green-600 font-semibold text-sm mb-2">
                                        <i class="fa-solid fa-rotate-left"></i>
                                        Pulang
                                    </div>
                                    <div class="font-bold text-gray-800">{{ $selectedReturn['origin'] }} →
                                        {{ $selectedReturn['destination'] }}</div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        <i class="fa-solid fa-ship mr-1"></i>{{ $selectedReturn['ship_name'] }}
                                        ({{ $selectedReturn['operator'] }})
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        <i
                                            class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($returnDate)->translatedFormat('l, d M Y') }}
                                        <span class="mx-1">•</span>
                                        <i class="fa-regular fa-clock mr-1"></i>{{ $selectedReturn['departure_time'] }}
                                        - {{ $selectedReturn['arrival_time'] }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <i class="fa-solid fa-users mr-1"></i>{{ $passengers }} penumpang
                                    </div>
                                    <div class="mt-2 font-bold text-green-600">
                                        {{ $selectedReturn['total_price_formatted'] }}</div>
                                </div>
                            @elseif($returnTrip && !$selectedReturn)
                                <div
                                    class="bg-white rounded-xl p-4 border border-dashed border-gray-300 flex items-center justify-center">
                                    <p class="text-gray-400 text-sm"><i
                                            class="fa-solid fa-hand-pointer mr-1"></i>Silakan pilih jadwal pulang</p>
                                </div>
                            @endif
                        </div>

                        <!-- Total and CTA -->
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-200">
                            <div>
                                <div class="text-sm text-gray-600">Total Pembayaran</div>
                                <div class="text-3xl font-bold text-gray-800">
                                    Rp {{ number_format($selectedTotal, 0, ',', '.') }}
                                </div>
                            </div>

                            @if (!$returnTrip || ($returnTrip && $selectedReturnScheduleId))
                                <button x-data
                                    @click="confirmAction('Lanjutkan ke halaman pemesanan?', 'Konfirmasi').then(confirmed => { if(confirmed) $wire.proceedToBooking(); })"
                                    wire:loading.attr="disabled"
                                    class="bg-linear-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer flex items-center justify-center gap-2">
                                    <span wire:loading.remove wire:target="proceedToBooking">
                                        Lanjut ke Pemesanan
                                        <i class="fa-solid fa-arrow-right ml-1"></i>
                                    </span>
                                    <span wire:loading wire:target="proceedToBooking">
                                        <i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses...
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
