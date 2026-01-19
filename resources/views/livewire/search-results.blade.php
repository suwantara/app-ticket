<!-- Search Results Component -->
<div>
    {{-- Loading State (during search) --}}
    @if ($isSearching)
        <div class="max-w-7xl mx-auto mt-8 px-4 lg:px-0">
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden p-6">
                <div class="animate-pulse space-y-4">
                    {{-- Header skeleton --}}
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-200 rounded-lg"></div>
                        <div class="h-6 bg-gray-200 rounded w-48"></div>
                    </div>
                    {{-- Schedule items skeleton --}}
                    @for ($i = 0; $i < 3; $i++)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                            <div class="w-5 h-5 bg-gray-200 rounded-full"></div>
                            <div class="flex-1 space-y-2">
                                <div class="h-4 bg-gray-200 rounded w-32"></div>
                                <div class="h-3 bg-gray-200 rounded w-24"></div>
                            </div>
                            <div class="space-y-2 text-center">
                                <div class="h-4 bg-gray-200 rounded w-24"></div>
                                <div class="h-3 bg-gray-200 rounded w-16 mx-auto"></div>
                            </div>
                            <div class="space-y-2 text-right">
                                <div class="h-5 bg-gray-200 rounded w-28 ml-auto"></div>
                                <div class="h-3 bg-gray-200 rounded w-16 ml-auto"></div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="mt-4 flex items-center justify-center gap-2 text-blue-600">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span class="text-sm font-medium">Mencari jadwal tersedia...</span>
                </div>
            </div>
        </div>

        {{-- Results State (after search) --}}
    @elseif ($showResults)
        <div class="max-w-7xl mx-auto mt-8 px-4 lg:px-0" id="search-results">
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden">

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
                                    ? 'bg-yellow-50 border-2 border-yellow-500 shadow-md'
                                    : 'bg-gray-50 border-2 border-transparent hover:bg-yellow-50/50 hover:border-yellow-200' }}">

                                    <!-- Selection Radio -->
                                    <div class="shrink-0">
                                        <div
                                            class="w-5 h-5 rounded-full border-2 flex items-center justify-center
                                        {{ $selectedScheduleId == $schedule['id'] ? 'border-yellow-500 bg-yellow-500' : 'border-gray-300' }}">
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
                                    ? 'bg-green-50 border-2 border-green-500 shadow-md'
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
                    <div class="p-6 bg-neutral-primary border border-gray-200 rounded-xl">
                        <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-clipboard-list text-blue-900"></i>
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
                                <div class="mt-2 font-bold text-blue-900">
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
                                        <i
                                            class="fa-regular fa-clock mr-1"></i>{{ $selectedReturn['departure_time'] }}
                                        - {{ $selectedReturn['arrival_time'] }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <i class="fa-solid fa-users mr-1"></i>{{ $passengers }} penumpang
                                    </div>
                                    <div class="mt-2 font-bold text-green-900">
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
                                @auth
                                    {{-- User sudah login - langsung ke pemesanan --}}
                                    <button x-data
                                        @click="confirmAction('Lanjutkan ke halaman pemesanan?', 'Konfirmasi').then(confirmed => { if(confirmed) $wire.proceedToBooking(); })"
                                        wire:loading.attr="disabled"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-black px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer flex items-center justify-center gap-2">
                                        <span wire:loading.remove wire:target="proceedToBooking">
                                            Lanjut ke Pemesanan
                                            <i class="fa-solid fa-arrow-right ml-1"></i>
                                        </span>
                                        <span wire:loading wire:target="proceedToBooking">
                                            <i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses...
                                        </span>
                                    </button>
                                @else
                                    {{-- User belum login - trigger modal login --}}
                                    <button @click="$dispatch('open-login-modal')" type="button"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-black px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer flex items-center justify-center gap-2">
                                        Lanjut ke Pemesanan
                                        <i class="fa-solid fa-arrow-right ml-1"></i>
                                    </button>
                                @endauth
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Initial State (before search) --}}
    @else
        <div class="max-w-7xl mx-auto mt-8 px-4 lg:px-0">
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden p-8">
                {{-- Engaging Visual --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-4">
                        <i class="fa-solid fa-ship text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Cari Jadwal Fast Boat</h3>
                    <p class="text-gray-500">Isi form di atas untuk mencari jadwal keberangkatan yang tersedia</p>
                </div>

                {{-- Popular Routes --}}
                @if (count($popularRoutes) > 0)
                    <div class="border-t border-gray-100 pt-6">
                        <h4 class="text-sm font-semibold text-gray-600 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-fire text-orange-500"></i>
                            Rute Populer
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($popularRoutes as $route)
                                <button type="button"
                                    wire:click="selectPopularRoute({{ $route['origin_id'] }}, {{ $route['destination_id'] }})"
                                    class="flex items-center gap-3 p-4 bg-gray-50 hover:bg-blue-50 border border-gray-100 hover:border-blue-200 rounded-xl transition-all duration-200 text-left group">
                                    <div
                                        class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-lg flex items-center justify-center transition-colors">
                                        <i class="fa-solid fa-route text-blue-600"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div
                                            class="font-semibold text-gray-800 group-hover:text-blue-700 transition-colors">
                                            {{ $route['origin_name'] }}
                                            <i class="fa-solid fa-arrow-right text-xs text-gray-400 mx-1"></i>
                                            {{ $route['destination_name'] }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <i class="fa-regular fa-clock mr-1"></i>{{ $route['duration'] }}
                                        </div>
                                    </div>
                                    <i
                                        class="fa-solid fa-chevron-right text-gray-300 group-hover:text-blue-500 transition-colors"></i>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Tips --}}
                <div class="mt-6 p-4 bg-amber-50 border border-amber-100 rounded-xl">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-lightbulb text-amber-500 mt-0.5"></i>
                        <div class="text-sm text-amber-800">
                            <span class="font-medium">Tips:</span> Pilih tanggal keberangkatan minimal H-1 untuk
                            mendapatkan harga terbaik dan ketersediaan kursi yang lebih banyak.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Login Required Modal - Full Page Overlay (tetap di dalam root div tapi dengan fixed positioning) --}}
    @guest
        <div x-data="{ showLoginModal: false }" x-on:open-login-modal.window="showLoginModal = true" x-cloak>

            {{-- Modal Overlay --}}
            <div x-show="showLoginModal" class="fixed inset-0 z-[9999] overflow-y-auto"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" @click="showLoginModal = false"></div>

                {{-- Modal Container --}}
                <div class="flex items-center justify-center min-h-screen p-4">
                    {{-- Modal Content --}}
                    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 z-10" x-show="showLoginModal"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 scale-95" @click.stop>

                        {{-- Close Button --}}
                        <button @click="showLoginModal = false"
                            class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all">
                            <i class="fa-solid fa-times text-xl"></i>
                        </button>

                        {{-- Icon --}}
                        <div class="text-center mb-6">
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 bg-linear-to-br from-orange-100 to-amber-100 rounded-full mb-4">
                                <i class="fa-solid fa-user-lock text-orange-500 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Login Diperlukan</h3>
                            <p class="text-gray-500 mt-2">Silakan login atau daftar terlebih dahulu untuk melanjutkan
                                pemesanan
                                tiket.</p>
                        </div>

                        {{-- Buttons --}}
                        <div class="space-y-3">
                            <a href="{{ route('login') }}?redirect={{ route('ticket') }}"
                                class="block w-full text-center bg-linear-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-4 rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fa-solid fa-sign-in-alt mr-2"></i>
                                Login
                            </a>
                            <a href="{{ route('register') }}?redirect={{ route('ticket') }}"
                                class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-4 rounded-xl font-bold transition-all duration-200">
                                <i class="fa-solid fa-user-plus mr-2"></i>
                                Daftar Akun Baru
                            </a>
                        </div>

                        {{-- Info --}}
                        <div class="mt-6 p-4 bg-blue-50 rounded-xl">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-info-circle text-blue-500 mt-0.5"></i>
                                <div class="text-sm text-blue-700">
                                    <span class="font-medium">Mengapa harus login?</span>
                                    <ul class="mt-1 space-y-1 text-blue-600">
                                        <li>• Menyimpan riwayat pemesanan</li>
                                        <li>• Akses e-ticket dengan mudah</li>
                                        <li>• Proses booking lebih cepat</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endguest
</div>
