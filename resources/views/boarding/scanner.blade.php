<x-layouts.app title="QR Scanner - Boarding">
    <div class="min-h-screen bg-slate-900">
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
                            <h1 class="text-xl font-bold">QR Scanner</h1>
                            @if($schedule)
                                <p class="text-slate-400 text-sm">
                                    {{ $schedule->route->origin->name }} → {{ $schedule->route->destination->name }}
                                    • {{ \Carbon\Carbon::parse($schedule->departure_time)->format('H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span id="boarding-stats" class="px-3 py-1 bg-emerald-600 rounded-full text-sm font-medium">
                            <span id="boarded-count">0</span>/<span id="total-count">0</span> Boarded
                        </span>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto px-4 py-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Scanner Area -->
                <div class="bg-slate-800 rounded-2xl overflow-hidden">
                    <div class="p-4 border-b border-slate-700">
                        <h2 class="text-white font-semibold">Arahkan kamera ke QR Code</h2>
                    </div>
                    
                    <div class="relative">
                        <!-- Camera View -->
                        <div id="qr-reader" class="w-full aspect-square bg-black"></div>
                        
                        <!-- Scanning Overlay -->
                        <div id="scanning-overlay" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="w-64 h-64 relative">
                                <!-- Corner Markers -->
                                <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-blue-500"></div>
                                <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-blue-500"></div>
                                <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-blue-500"></div>
                                <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-blue-500"></div>
                                <!-- Scan Line Animation -->
                                <div class="absolute inset-x-0 h-0.5 bg-blue-500 animate-scan"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Camera Controls -->
                    <div class="p-4 flex justify-center space-x-4">
                        <button id="btn-start" onclick="startScanner()" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Mulai Scan
                        </button>
                        <button id="btn-stop" onclick="stopScanner()" 
                                class="px-6 py-3 bg-slate-600 text-white rounded-xl hover:bg-slate-700 transition font-medium hidden">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                            </svg>
                            Stop
                        </button>
                        <button id="btn-switch" onclick="switchCamera()" 
                                class="px-4 py-3 bg-slate-700 text-white rounded-xl hover:bg-slate-600 transition hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Result Area -->
                <div class="space-y-6">
                    <!-- Current Scan Result -->
                    <div id="scan-result" class="bg-slate-800 rounded-2xl p-6 hidden">
                        <div id="result-content"></div>
                    </div>

                    <!-- Manual Input -->
                    <div class="bg-slate-800 rounded-2xl p-6">
                        <h3 class="text-white font-semibold mb-4">Input Manual</h3>
                        <div class="flex space-x-2">
                            <input type="text" id="manual-input" placeholder="Masukkan nomor tiket..." 
                                   class="flex-1 px-4 py-3 bg-slate-700 border border-slate-600 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button onclick="manualValidate()" 
                                    class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium">
                                Cek
                            </button>
                        </div>
                    </div>

                    <!-- Recent Scans -->
                    <div class="bg-slate-800 rounded-2xl overflow-hidden">
                        <div class="p-4 border-b border-slate-700 flex justify-between items-center">
                            <h3 class="text-white font-semibold">Scan Terakhir</h3>
                            <button onclick="clearHistory()" class="text-slate-400 hover:text-white text-sm">Clear</button>
                        </div>
                        <div id="scan-history" class="max-h-64 overflow-y-auto">
                            <div class="p-4 text-center text-slate-500 text-sm">
                                Belum ada scan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Success Modal -->
        <div id="success-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 text-center transform transition-all scale-95 opacity-0" id="success-modal-content">
                <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Boarding Berhasil!</h3>
                <p id="success-passenger-name" class="text-slate-600 mb-6"></p>
                <button onclick="closeSuccessModal()" class="w-full py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition">
                    Lanjut Scan
                </button>
            </div>
        </div>

        <!-- Error Modal -->
        <div id="error-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 text-center transform transition-all scale-95 opacity-0" id="error-modal-content">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Gagal!</h3>
                <p id="error-message" class="text-slate-600 mb-6"></p>
                <button onclick="closeErrorModal()" class="w-full py-3 bg-slate-600 text-white rounded-xl font-medium hover:bg-slate-700 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <style>
        @keyframes scan {
            0%, 100% { top: 0; }
            50% { top: calc(100% - 2px); }
        }
        .animate-scan {
            animation: scan 2s ease-in-out infinite;
        }
        #qr-reader video {
            width: 100% !important;
            height: auto !important;
            object-fit: cover;
        }
        #qr-reader__scan_region {
            min-height: 300px;
        }
    </style>

    <!-- html5-qrcode Library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        let html5QrCode = null;
        let isScanning = false;
        let lastScannedCode = null;
        let scanHistory = [];
        const scheduleId = {{ $schedule ? $schedule->id : 'null' }};

        // Initialize scanner
        document.addEventListener('DOMContentLoaded', function() {
            html5QrCode = new Html5Qrcode("qr-reader");
            loadStats();
            // Auto-start scanner
            startScanner();
        });

        // Start camera scanner
        async function startScanner() {
            if (isScanning) return;

            try {
                const config = { 
                    fps: 10, 
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1
                };

                await html5QrCode.start(
                    { facingMode: "environment" }, // Back camera
                    config,
                    onScanSuccess,
                    onScanFailure
                );

                isScanning = true;
                document.getElementById('btn-start').classList.add('hidden');
                document.getElementById('btn-stop').classList.remove('hidden');
                document.getElementById('btn-switch').classList.remove('hidden');

            } catch (err) {
                console.error("Error starting scanner:", err);
                showError("Gagal mengakses kamera. Pastikan browser memiliki izin kamera.");
            }
        }

        // Stop scanner
        function stopScanner() {
            if (!isScanning) return;

            html5QrCode.stop().then(() => {
                isScanning = false;
                document.getElementById('btn-start').classList.remove('hidden');
                document.getElementById('btn-stop').classList.add('hidden');
                document.getElementById('btn-switch').classList.add('hidden');
            });
        }

        // Switch camera
        async function switchCamera() {
            if (!isScanning) return;

            await stopScanner();
            
            // Toggle camera
            const currentFacing = html5QrCode._currentFacingMode || "environment";
            const newFacing = currentFacing === "environment" ? "user" : "environment";

            try {
                await html5QrCode.start(
                    { facingMode: newFacing },
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    onScanSuccess,
                    onScanFailure
                );
                isScanning = true;
                document.getElementById('btn-start').classList.add('hidden');
                document.getElementById('btn-stop').classList.remove('hidden');
            } catch (err) {
                console.error("Error switching camera:", err);
                startScanner();
            }
        }

        // On successful scan
        function onScanSuccess(decodedText, decodedResult) {
            // Prevent duplicate scans
            if (lastScannedCode === decodedText) return;
            lastScannedCode = decodedText;

            // Play beep sound
            playBeep();

            // Validate the QR code
            validateTicket(decodedText);

            // Reset after delay to allow same code to be scanned again
            setTimeout(() => {
                lastScannedCode = null;
            }, 3000);
        }

        // On scan failure (no QR detected)
        function onScanFailure(error) {
            // Silent - no QR code in view
        }

        // Manual input validation
        function manualValidate() {
            const input = document.getElementById('manual-input').value.trim();
            if (!input) {
                showError("Masukkan nomor tiket terlebih dahulu");
                return;
            }
            validateTicket(input);
            document.getElementById('manual-input').value = '';
        }

        // Validate ticket via API
        async function validateTicket(qrData) {
            showLoading();

            try {
                const response = await fetch('{{ route("boarding.validate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        qr_data: qrData,
                        schedule_id: scheduleId
                    })
                });

                const data = await response.json();
                hideLoading();

                if (data.valid) {
                    showTicketInfo(data);
                } else {
                    showError(data.message);
                    addToHistory(qrData, false, data.message);
                }

            } catch (error) {
                hideLoading();
                showError("Terjadi kesalahan. Coba lagi.");
                console.error(error);
            }
        }

        // Board passenger
        async function boardPassenger(ticketId) {
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
                    showSuccessModal(data.passenger_name);
                    addToHistory(data.ticket_number, true, 'Boarded');
                    loadStats();
                } else {
                    showError(data.message);
                }

            } catch (error) {
                showError("Gagal memproses boarding");
                console.error(error);
            }
        }

        // Show ticket info
        function showTicketInfo(data) {
            const resultDiv = document.getElementById('scan-result');
            const contentDiv = document.getElementById('result-content');
            
            let statusBadge = '';
            let actionButton = '';
            
            if (data.ticket.status === 'unused') {
                statusBadge = '<span class="px-3 py-1 bg-emerald-600 text-white rounded-full text-sm">Valid</span>';
                actionButton = `
                    <button onclick="boardPassenger(${data.ticket.id})" 
                            class="w-full py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Boarding Penumpang
                    </button>
                `;
            } else if (data.ticket.status === 'used') {
                statusBadge = '<span class="px-3 py-1 bg-amber-600 text-white rounded-full text-sm">Sudah Digunakan</span>';
                actionButton = `
                    <div class="py-3 bg-amber-600/20 text-amber-500 rounded-xl text-center">
                        Tiket sudah digunakan pada ${data.ticket.used_at}
                    </div>
                `;
            } else {
                statusBadge = '<span class="px-3 py-1 bg-red-600 text-white rounded-full text-sm">' + data.ticket.status_label + '</span>';
            }

            contentDiv.innerHTML = `
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-semibold">Informasi Tiket</h3>
                    ${statusBadge}
                </div>
                <div class="bg-slate-700/50 rounded-xl p-4 mb-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-slate-400">No. Tiket</span>
                        <span class="text-white font-mono">${data.ticket.ticket_number}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Penumpang</span>
                        <span class="text-white">${data.passenger.name}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">ID</span>
                        <span class="text-white">${data.passenger.id_number}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Rute</span>
                        <span class="text-white">${data.schedule.route}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Keberangkatan</span>
                        <span class="text-white">${data.schedule.date} ${data.schedule.time}</span>
                    </div>
                </div>
                ${actionButton}
            `;

            resultDiv.classList.remove('hidden');
        }

        // Show success modal
        function showSuccessModal(passengerName) {
            document.getElementById('success-passenger-name').textContent = passengerName;
            const modal = document.getElementById('success-modal');
            const content = document.getElementById('success-modal-content');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            // Auto close after 2 seconds
            setTimeout(closeSuccessModal, 2000);
        }

        function closeSuccessModal() {
            const modal = document.getElementById('success-modal');
            const content = document.getElementById('success-modal-content');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('scan-result').classList.add('hidden');
            }, 200);
        }

        // Show error
        function showError(message) {
            document.getElementById('error-message').textContent = message;
            const modal = document.getElementById('error-modal');
            const content = document.getElementById('error-modal-content');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeErrorModal() {
            const modal = document.getElementById('error-modal');
            const content = document.getElementById('error-modal-content');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        // Loading state
        function showLoading() {
            const resultDiv = document.getElementById('scan-result');
            const contentDiv = document.getElementById('result-content');
            
            contentDiv.innerHTML = `
                <div class="text-center py-8">
                    <svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-slate-400 mt-2">Memvalidasi tiket...</p>
                </div>
            `;
            
            resultDiv.classList.remove('hidden');
        }

        function hideLoading() {
            // Will be replaced by actual content
        }

        // Add to scan history
        function addToHistory(code, success, message) {
            scanHistory.unshift({
                code: code,
                success: success,
                message: message,
                time: new Date().toLocaleTimeString('id-ID')
            });

            // Keep only last 10
            scanHistory = scanHistory.slice(0, 10);
            renderHistory();
        }

        function renderHistory() {
            const historyDiv = document.getElementById('scan-history');
            
            if (scanHistory.length === 0) {
                historyDiv.innerHTML = `
                    <div class="p-4 text-center text-slate-500 text-sm">
                        Belum ada scan
                    </div>
                `;
                return;
            }

            historyDiv.innerHTML = scanHistory.map(item => `
                <div class="px-4 py-3 border-b border-slate-700 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center ${item.success ? 'bg-emerald-600' : 'bg-red-600'}">
                            ${item.success 
                                ? '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
                                : '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>'
                            }
                        </div>
                        <div>
                            <p class="text-white text-sm font-mono">${item.code.substring(0, 20)}${item.code.length > 20 ? '...' : ''}</p>
                            <p class="text-slate-500 text-xs">${item.message}</p>
                        </div>
                    </div>
                    <span class="text-slate-500 text-xs">${item.time}</span>
                </div>
            `).join('');
        }

        function clearHistory() {
            scanHistory = [];
            renderHistory();
        }

        // Load boarding stats
        async function loadStats() {
            try {
                const url = scheduleId 
                    ? `{{ route("boarding.stats") }}?schedule_id=${scheduleId}`
                    : '{{ route("boarding.stats") }}';
                    
                const response = await fetch(url);
                const data = await response.json();
                
                document.getElementById('boarded-count').textContent = data.boarded;
                document.getElementById('total-count').textContent = data.total;
            } catch (error) {
                console.error("Error loading stats:", error);
            }
        }

        // Play beep sound
        function playBeep() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.value = 1000;
            oscillator.type = 'sine';
            
            gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.1);
        }

        // Enter key for manual input
        document.getElementById('manual-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                manualValidate();
            }
        });
    </script>
</x-layouts.app>
