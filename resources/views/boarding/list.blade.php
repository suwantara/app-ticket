<x-layouts.app title="Daftar Boarding">
    <div class="min-h-screen bg-slate-100">
        <!-- Header -->
        <header class="bg-slate-800 text-white shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('boarding.dashboard') }}" class="text-slate-400 hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-xl font-bold">Daftar Penumpang</h1>
                            @if($schedule)
                                <p class="text-slate-400 text-sm">
                                    {{ $schedule->route->origin->name }} → {{ $schedule->route->destination->name }}
                                    • {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }} WIB
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('boarding.scanner', $schedule ? ['schedule' => $schedule->id] : []) }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            Scan
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <p class="text-slate-500 text-sm">Total</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $tickets->count() }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <p class="text-slate-500 text-sm">Boarded</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ $tickets->where('status', 'used')->count() }}</p>
                </div>
                <div class="bg-white rounded-xl p-4 shadow-sm">
                    <p class="text-slate-500 text-sm">Pending</p>
                    <p class="text-2xl font-bold text-amber-600">{{ $tickets->where('status', 'unused')->count() }}</p>
                </div>
            </div>

            <!-- Filter & Search -->
            <div class="bg-white rounded-xl p-4 shadow-sm mb-6">
                <div class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" id="search-input" placeholder="Cari nama atau nomor tiket..." 
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="filterStatus('all')" data-filter="all"
                                class="filter-btn px-4 py-2 rounded-lg bg-blue-600 text-white transition">
                            Semua
                        </button>
                        <button onclick="filterStatus('boarded')" data-filter="boarded"
                                class="filter-btn px-4 py-2 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 transition">
                            Sudah Boarding
                        </button>
                        <button onclick="filterStatus('pending')" data-filter="pending"
                                class="filter-btn px-4 py-2 rounded-lg bg-slate-200 text-slate-700 hover:bg-slate-300 transition">
                            Belum Boarding
                        </button>
                    </div>
                </div>
            </div>

            <!-- Passenger List -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                    Penumpang
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                    No. Tiket
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                    Waktu Boarding
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody id="passenger-table" class="bg-white divide-y divide-slate-200">
                            @forelse($tickets as $ticket)
                                <tr class="passenger-row hover:bg-slate-50 transition" 
                                    data-name="{{ strtolower($ticket->passenger->name) }}"
                                    data-ticket="{{ strtolower($ticket->ticket_number) }}"
                                    data-status="{{ $ticket->status === 'used' ? 'boarded' : 'pending' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-{{ $ticket->status === 'used' ? 'emerald' : 'slate' }}-100 rounded-full flex items-center justify-center">
                                                <span class="text-{{ $ticket->status === 'used' ? 'emerald' : 'slate' }}-600 font-medium">
                                                    {{ strtoupper(substr($ticket->passenger->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-slate-900">{{ $ticket->passenger->name }}</div>
                                                <div class="text-sm text-slate-500">{{ ucfirst($ticket->passenger->type) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-sm text-slate-800">{{ $ticket->ticket_number }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                        {{ $ticket->passenger->id_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($ticket->status === 'used')
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
                                                Boarded
                                            </span>
                                        @elseif($ticket->status === 'unused')
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">
                                                Pending
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                        @if($ticket->used_at)
                                            {{ \Carbon\Carbon::parse($ticket->used_at)->format('H:i:s') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($ticket->status === 'unused')
                                            <button onclick="boardPassenger({{ $ticket->id }}, '{{ $ticket->passenger->name }}')" 
                                                    class="px-3 py-1 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-xs">
                                                Board
                                            </button>
                                        @else
                                            <span class="text-slate-400">✓</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <p>Tidak ada penumpang</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        let currentFilter = 'all';

        // Search functionality
        document.getElementById('search-input').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            applyFilters(query, currentFilter);
        });

        // Filter by status
        function filterStatus(status) {
            currentFilter = status;
            
            // Update button styles
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-slate-200', 'text-slate-700');
            });
            document.querySelector(`[data-filter="${status}"]`).classList.remove('bg-slate-200', 'text-slate-700');
            document.querySelector(`[data-filter="${status}"]`).classList.add('bg-blue-600', 'text-white');

            const query = document.getElementById('search-input').value.toLowerCase();
            applyFilters(query, status);
        }

        // Apply both search and filter
        function applyFilters(query, status) {
            document.querySelectorAll('.passenger-row').forEach(row => {
                const name = row.dataset.name;
                const ticket = row.dataset.ticket;
                const rowStatus = row.dataset.status;

                const matchesSearch = name.includes(query) || ticket.includes(query);
                const matchesFilter = status === 'all' || rowStatus === status;

                row.style.display = matchesSearch && matchesFilter ? '' : 'none';
            });
        }

        // Board passenger
        async function boardPassenger(ticketId, passengerName) {
            if (!confirm(`Boarding penumpang: ${passengerName}?`)) return;

            try {
                const response = await fetch('{{ route("boarding.board") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ticket_id: ticketId
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Reload page to refresh data
                    window.location.reload();
                } else {
                    alert(data.message);
                }

            } catch (error) {
                alert("Gagal memproses boarding");
                console.error(error);
            }
        }
    </script>
</x-layouts.app>
