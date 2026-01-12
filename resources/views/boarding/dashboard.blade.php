<x-layouts.app title="Boarding Dashboard">
    <div class="min-h-screen bg-slate-100">
        <!-- Header -->
        <header class="bg-slate-800 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="h-10 w-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">Boarding System</h1>
                            <p class="text-slate-400 text-sm">{{ now()->format('l, d F Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-slate-300">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('staff.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('boarding.scanner') }}" 
                   class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 text-white hover:shadow-lg transition transform hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="h-14 w-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Scan QR Code</h3>
                            <p class="text-blue-200 text-sm">Validasi tiket penumpang</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('boarding.list') }}" 
                   class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl p-6 text-white hover:shadow-lg transition transform hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="h-14 w-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Daftar Boarding</h3>
                            <p class="text-emerald-200 text-sm">Lihat manifest penumpang</p>
                        </div>
                    </div>
                </a>

                <a href="/admin/tickets" 
                   class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl p-6 text-white hover:shadow-lg transition transform hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="h-14 w-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Kelola Tiket</h3>
                            <p class="text-purple-200 text-sm">Admin panel tiket</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Today's Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm">Total Order</p>
                            <p class="text-3xl font-bold text-slate-800">{{ $todayStats['total_orders'] }}</p>
                        </div>
                        <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm">Total Penumpang</p>
                            <p class="text-3xl font-bold text-slate-800">{{ $todayStats['total_passengers'] }}</p>
                        </div>
                        <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm">Sudah Boarding</p>
                            <p class="text-3xl font-bold text-emerald-600">{{ $todayStats['boarded'] }}</p>
                        </div>
                        <div class="h-12 w-12 bg-emerald-100 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm">Belum Boarding</p>
                            <p class="text-3xl font-bold text-amber-600">{{ $todayStats['pending'] }}</p>
                        </div>
                        <div class="h-12 w-12 bg-amber-100 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule List -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-slate-800">Jadwal Hari Ini</h2>
                    <span class="text-sm text-slate-500">{{ now()->format('d M Y') }}</span>
                </div>

                @if($schedules->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-slate-500">Tidak ada jadwal dengan tiket hari ini</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-200">
                        @foreach($schedules as $item)
                            <div class="p-6 hover:bg-slate-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-slate-800">
                                                {{ $item['schedule']->route->origin->name }} → {{ $item['schedule']->route->destination->name }}
                                            </h3>
                                            <p class="text-sm text-slate-500">
                                                {{ $item['schedule']->ship->name }} • 
                                                {{ \Carbon\Carbon::parse($item['schedule']->departure_time)->format('H:i') }} WIB
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-6">
                                        <!-- Progress -->
                                        <div class="text-right">
                                            <p class="text-sm text-slate-500">Boarding Progress</p>
                                            <div class="flex items-center space-x-2">
                                                <div class="w-32 h-2 bg-slate-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-emerald-500 rounded-full" 
                                                         style="width: {{ $item['boarding_percentage'] }}%"></div>
                                                </div>
                                                <span class="text-sm font-medium text-slate-700">
                                                    {{ $item['used_tickets'] }}/{{ $item['total_tickets'] }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex space-x-2">
                                            <a href="{{ route('boarding.scanner', ['schedule' => $item['schedule']->id]) }}" 
                                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                                Scan
                                            </a>
                                            <a href="{{ route('boarding.list', ['schedule' => $item['schedule']->id]) }}" 
                                               class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition text-sm font-medium">
                                                List
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </main>
    </div>
</x-layouts.app>
