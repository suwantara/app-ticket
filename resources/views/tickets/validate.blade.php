<x-layouts.app title="Validasi Tiket">
    <div class="min-h-screen bg-linear-to-br from-gray-50 to-gray-100 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Validasi Tiket</h1>
                <p class="text-gray-600">Scan QR Code atau masukkan nomor tiket untuk validasi</p>
            </div>

            <!-- Search Form -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="p-6">
                    <form id="searchForm" class="space-y-4">
                        <div>
                            <label for="ticketCode" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Tiket / QR Code
                            </label>
                            <div class="flex gap-3">
                                <input type="text"
                                       id="ticketCode"
                                       name="ticketCode"
                                       placeholder="Masukkan nomor tiket atau scan QR code"
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg font-mono"
                                       autofocus>
                                <button type="submit"
                                        class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Result Container -->
            <div id="resultContainer" class="hidden">
                <!-- Will be populated by JavaScript -->
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Instruksi</h2>
                </div>
                <div class="p-6">
                    <ol class="list-decimal list-inside space-y-3 text-gray-600">
                        <li>Minta penumpang menunjukkan QR Code pada tiket</li>
                        <li>Scan QR Code menggunakan scanner atau masukkan kode manual</li>
                        <li>Verifikasi data penumpang dengan identitas asli</li>
                        <li>Jika valid, klik tombol "Gunakan Tiket" untuk menandai sudah digunakan</li>
                        <li>Tiket yang sudah digunakan tidak bisa digunakan lagi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const code = document.getElementById('ticketCode').value.trim();
            if (!code) return;

            const resultContainer = document.getElementById('resultContainer');
            resultContainer.classList.remove('hidden');
            resultContainer.innerHTML = '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div><p class="mt-4 text-gray-600">Mencari tiket...</p></div>';

            try {
                const response = await fetch(`{{ url('/api/ticket/validate') }}/${encodeURIComponent(code)}`);
                const data = await response.json();

                if (data.valid) {
                    const ticket = data.ticket;
                    resultContainer.innerHTML = `
                        <div class="bg-green-50 border-2 border-green-400 rounded-2xl overflow-hidden mb-8">
                            <div class="bg-green-400 px-6 py-3 flex items-center">
                                <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-white font-semibold text-lg">TIKET VALID</span>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-500">Nama Penumpang</p>
                                        <p class="text-xl font-bold text-gray-900">${ticket.passenger.name}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">No. Tiket</p>
                                        <p class="font-mono font-semibold text-blue-600">${ticket.ticket_number}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Rute</p>
                                        <p class="font-semibold text-gray-900">${ticket.order.schedule.route.origin.name} → ${ticket.order.schedule.route.destination.name}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal</p>
                                        <p class="font-semibold text-gray-900">${new Date(ticket.order.travel_date).toLocaleDateString('id-ID')}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Kapal</p>
                                        <p class="font-semibold text-gray-900">${ticket.order.schedule.ship.name}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tipe ID</p>
                                        <p class="font-semibold text-gray-900">${ticket.passenger.id_type.toUpperCase()}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">No. Identitas</p>
                                        <p class="font-semibold text-gray-900">${ticket.passenger.id_number}</p>
                                    </div>
                                </div>
                                <button onclick="useTicket(${ticket.id}, '${ticket.qr_code}')"
                                        class="w-full py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-semibold text-lg">
                                    ✓ Gunakan Tiket Sekarang
                                </button>
                            </div>
                        </div>
                    `;
                } else {
                    resultContainer.innerHTML = `
                        <div class="bg-red-50 border-2 border-red-400 rounded-2xl overflow-hidden mb-8">
                            <div class="bg-red-400 px-6 py-3 flex items-center">
                                <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-white font-semibold text-lg">TIKET TIDAK VALID</span>
                            </div>
                            <div class="p-6">
                                <p class="text-red-700 text-lg">${data.message}</p>
                                ${data.ticket ? `
                                    <div class="mt-4 pt-4 border-t border-red-200">
                                        <p class="text-sm text-gray-500">No. Tiket: <span class="font-mono">${data.ticket.ticket_number}</span></p>
                                        <p class="text-sm text-gray-500">Status: <span class="font-semibold">${data.ticket.status}</span></p>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                }
            } catch (error) {
                resultContainer.innerHTML = `
                    <div class="bg-red-50 border-2 border-red-400 rounded-2xl p-6 mb-8">
                        <p class="text-red-700">Terjadi kesalahan saat mencari tiket. Silakan coba lagi.</p>
                    </div>
                `;
            }
        });

        async function useTicket(ticketId, qrCode) {
            if (!confirm('Apakah Anda yakin ingin menandai tiket ini sebagai sudah digunakan?')) {
                return;
            }

            try {
                const response = await fetch(`{{ url('/api/ticket/use') }}/${ticketId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ used_by: 'Staff' })
                });

                const data = await response.json();

                if (data.success) {
                    document.getElementById('resultContainer').innerHTML = `
                        <div class="bg-blue-50 border-2 border-blue-400 rounded-2xl overflow-hidden mb-8">
                            <div class="bg-blue-400 px-6 py-3 flex items-center">
                                <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-white font-semibold text-lg">TIKET TELAH DIGUNAKAN</span>
                            </div>
                            <div class="p-6 text-center">
                                <p class="text-blue-700 text-lg mb-4">Tiket berhasil ditandai sebagai sudah digunakan.</p>
                                <button onclick="location.reload()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Scan Tiket Lain
                                </button>
                            </div>
                        </div>
                    `;
                    document.getElementById('ticketCode').value = '';
                } else {
                    alert('Gagal: ' + data.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        }
    </script>
</x-layouts.app>
