<div>
    {{-- Jadwal & Rute Populer Hari Ini --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
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
                                    <p class="text-xl font-bold text-yellow-400">{{ $schedule->price_formatted }}</p>
                                </div>
                            </div>

                            {{-- Ship Info & CTA --}}
                            <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-ship text-gray-200"></i>
                                    <span
                                        class="text-sm text-gray-200">{{ $schedule->ship->name ?? 'Fast Boat' }}</span>
                                </div>
                                <a href="{{ route('booking.form', ['schedule' => $schedule->id]) }}"
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
                    <h3 class="text-xl font-semibold text-gray-200 mb-2">Tidak ada jadwal tersedia hari ini</h3>
                    <p class="text-gray-200 mb-6">Silakan cek jadwal untuk tanggal lain</p>
                    <a href="{{ route('booking.form') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300">
                        <span>Cari Jadwal Lain</span>
                    </a>
                </div>
            @endif
        </div>
    </section>
</div>
