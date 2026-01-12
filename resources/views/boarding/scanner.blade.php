<x-layouts.staff title="QR Scanner - Boarding">
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
        <div id="success-modal" class="fixed inset-0 bg-black/80 items-center justify-center z-50 hidden">
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
        <div id="error-modal" class="fixed inset-0 bg-black/80 items-center justify-center z-50 hidden">
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
            width: auto !important;
            height: 100% !important;
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
        let cameras = [];
        let currentCameraIndex = 0;
        const scheduleId = {{ $schedule ? $schedule->id : 'null' }};

        function safeEl(id) { return document.getElementById(id); }

        async function listCameras() {
            try {
                const list = await Html5Qrcode.getCameras();
                cameras = Array.isArray(list) ? list : [];

                if (cameras.length > 1) {
                    safeEl('btn-switch').classList.remove('hidden');
                } else {
                    safeEl('btn-switch').classList.add('hidden');
                }

                const rearIndex = cameras.findIndex(c => /rear|back|belakang|environment/i.test(c.label || ''));
                if (rearIndex >= 0) currentCameraIndex = rearIndex;
            } catch (e) {
                cameras = [];
                console.warn('Could not list cameras', e);
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
            html5QrCode = new Html5Qrcode("qr-reader");
            loadStats();
            renderHistory();
            await listCameras();
            startScanner();

            const manual = safeEl('manual-input');
            if (manual) {
                manual.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') manualValidate();
                });
            }
        });

        async function startScanner() {
            if (isScanning) return;

            if (!window.isSecureContext) {
                showError("Kamera memerlukan HTTPS. Gunakan 'localhost' atau HTTPS.");
                return;
            }

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                showError("Browser tidak mendukung akses kamera.");
                return;
            }

            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            const camera = cameras[currentCameraIndex];
            const cameraConfig = camera ? { deviceId: { exact: camera.id } } : { facingMode: "environment" };

            try {
                await html5QrCode.start(cameraConfig, config, onScanSuccess, onScanFailure);
                isScanning = true;
                safeEl('btn-start').classList.add('hidden');
                safeEl('btn-stop').classList.remove('hidden');
            } catch (err) {
                console.error('Error starting scanner', err);
                let msg = 'Gagal mengakses kamera.';
                if (err && err.name) {
                    if (err.name === 'NotAllowedError') msg = 'Izin kamera ditolak.';
                    else if (err.name === 'NotFoundError') msg = 'Tidak ada kamera yang terdeteksi.';
                    else if (err.name === 'NotReadableError') msg = 'Kamera sedang digunakan aplikasi lain.';
                    else if (err.name === 'OverconstrainedError') msg = 'Kamera tidak mendukung konfigurasi yang diminta.';
                }
                showError(msg);
            }
        }

        function stopScanner() {
            if (!isScanning) return;
            html5QrCode.stop().then(() => {
                isScanning = false;
                safeEl('btn-start').classList.remove('hidden');
                safeEl('btn-stop').classList.add('hidden');
            }).catch(err => {
                console.warn('Error stopping scanner', err);
                isScanning = false;
                safeEl('btn-start').classList.remove('hidden');
                safeEl('btn-stop').classList.add('hidden');
            });
        }

        async function switchCamera() {
            if (cameras.length <= 1) return;
            currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
            if (isScanning) {
                await stopScanner();
                await startScanner();
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (!decodedText) return;
            if (lastScannedCode === decodedText) return;
            lastScannedCode = decodedText;
            playBeep();
            validateTicket(decodedText);
            setTimeout(() => { lastScannedCode = null; }, 2000);
        }

        function onScanFailure(error) { /* ignore */ }

        function manualValidate() {
            const input = (safeEl('manual-input') || {}).value || '';
            const value = input.trim();
            if (!value) return showError('Masukkan nomor tiket terlebih dahulu');
            validateTicket(value);
            if (safeEl('manual-input')) safeEl('manual-input').value = '';
        }

        async function validateTicket(qrData, autoBoard = true) {
            showLoading();
            try {
                const response = await fetch('{{ route("boarding.validate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ qr_data: qrData, schedule_id: scheduleId, auto_board: autoBoard })
                });
                const data = await response.json();
                hideLoading();
                if (data.auto_boarded) {
                    showSuccessModal(data.passenger.name);
                    addToHistory(data.ticket.ticket_number, true, 'Boarding Otomatis Berhasil');
                    loadStats();
                } else if (data.ticket && data.ticket.status === 'used') {
                    showAlreadyUsedModal(data);
                    addToHistory(data.ticket.ticket_number, false, 'Sudah Digunakan');
                } else if (data.valid) {
                    showTicketInfo(data);
                } else {
                    showError(data.message || 'Tiket tidak valid');
                    addToHistory(qrData, false, data.message || 'Tidak valid');
                }
            } catch (err) {
                hideLoading();
                console.error(err);
                showError('Terjadi kesalahan. Coba lagi.');
            }
        }

        async function boardPassenger(ticketId) {
            try {
                const response = await fetch('{{ route("boarding.board") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ ticket_id: ticketId })
                });
                const data = await response.json();
                if (data.success) {
                    showSuccessModal(data.passenger_name);
                    addToHistory(data.ticket_number, true, 'Boarded');
                    loadStats();
                } else {
                    showError(data.message || 'Gagal memproses boarding');
                }
            } catch (err) {
                console.error(err);
                showError('Gagal memproses boarding');
            }
        }

        function showAlreadyUsedModal(data) {
            const resultDiv = safeEl('scan-result');
            const contentDiv = safeEl('result-content');
            contentDiv.innerHTML = `...`;
            resultDiv.classList.remove('hidden');
            setTimeout(() => resultDiv.classList.add('hidden'), 3000);
        }

        function showTicketInfo(data) {
            const resultDiv = safeEl('scan-result');
            const contentDiv = safeEl('result-content');
            let statusBadge = '';
            let actionButton = '';
            if (data.ticket.status === 'active') {
                statusBadge = '<span class="px-3 py-1 bg-emerald-600 text-white rounded-full text-sm">Valid</span>';
                actionButton = `<button onclick="boardPassenger(${data.ticket.id})" class="w-full py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition">Boarding Penumpang</button>`;
            } else if (data.ticket.status === 'used') {
                statusBadge = '<span class="px-3 py-1 bg-amber-600 text-white rounded-full text-sm">Sudah Digunakan</span>';
                actionButton = `<div class="py-3 bg-amber-600/20 text-amber-500 rounded-xl text-center">Tiket sudah digunakan pada ${data.ticket.used_at}</div>`;
            }
            contentDiv.innerHTML = `
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-white font-semibold">Informasi Tiket</h3>
                    ${statusBadge}
                </div>
                <div class="bg-slate-700/50 rounded-xl p-4 mb-4 space-y-3">
                    <div class="flex justify-between"><span class="text-slate-400">No. Tiket</span><span class="text-white font-mono">${data.ticket.ticket_number}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Penumpang</span><span class="text-white">${data.passenger.name}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">ID</span><span class="text-white">${data.passenger.id_number}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Rute</span><span class="text-white">${data.schedule.route}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Keberangkatan</span><span class="text-white">${data.schedule.date} ${data.schedule.time}</span></div>
                </div>
                ${actionButton}
            `;
            resultDiv.classList.remove('hidden');
        }

        function showSuccessModal(passengerName) {
            safeEl('success-passenger-name').textContent = passengerName;
            const modal = safeEl('success-modal');
            const content = safeEl('success-modal-content');
            modal.classList.remove('hidden'); modal.classList.add('flex');
            setTimeout(() => { content.classList.remove('scale-95','opacity-0'); content.classList.add('scale-100','opacity-100'); }, 10);
            setTimeout(closeSuccessModal, 2000);
        }

        function closeSuccessModal() {
            const modal = safeEl('success-modal');
            const content = safeEl('success-modal-content');
            content.classList.remove('scale-100','opacity-100'); content.classList.add('scale-95','opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); safeEl('scan-result').classList.add('hidden'); }, 200);
        }

        function showError(message) {
            safeEl('error-message').textContent = message;
            const modal = safeEl('error-modal');
            const content = safeEl('error-modal-content');
            modal.classList.remove('hidden'); modal.classList.add('flex');
            setTimeout(() => { content.classList.remove('scale-95','opacity-0'); content.classList.add('scale-100','opacity-100'); }, 10);
        }

        function closeErrorModal() {
            const modal = safeEl('error-modal'); const content = safeEl('error-modal-content');
            content.classList.remove('scale-100','opacity-100'); content.classList.add('scale-95','opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); }, 200);
        }

        function showLoading() {
            const resultDiv = safeEl('scan-result'); const contentDiv = safeEl('result-content');
            contentDiv.innerHTML = `<div class="text-center py-8"><svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle></svg><p class="text-slate-400 mt-2">Memvalidasi tiket...</p></div>`;
            resultDiv.classList.remove('hidden');
        }

        function hideLoading() { }

        function addToHistory(code, success, message) {
            scanHistory.unshift({ code, success, message, time: new Date().toLocaleTimeString('id-ID') });
            scanHistory = scanHistory.slice(0,10);
            renderHistory();
        }

        function renderHistory() {
            const historyDiv = safeEl('scan-history');
            if (!scanHistory.length) { historyDiv.innerHTML = `<div class="p-4 text-center text-slate-500 text-sm">Belum ada scan</div>`; return; }
            historyDiv.innerHTML = scanHistory.map(item => `
                <div class="px-4 py-3 border-b border-slate-700 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center ${item.success ? 'bg-emerald-600' : 'bg-red-600'}">${item.success ? '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>' : '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>'}</div>
                        <div><p class="text-white text-sm font-mono">${item.code.substring(0,20)}${item.code.length>20? '...' : ''}</p><p class="text-slate-500 text-xs">${item.message}</p></div>
                    </div>
                    <span class="text-slate-500 text-xs">${item.time}</span>
                </div>
            `).join('');
        }

        function clearHistory() { scanHistory = []; renderHistory(); }

        async function loadStats() {
            try {
                const url = scheduleId ? `{{ route("boarding.stats") }}?schedule_id=${scheduleId}` : '{{ route("boarding.stats") }}';
                const response = await fetch(url);
                const data = await response.json();
                safeEl('boarded-count').textContent = data.boarded; safeEl('total-count').textContent = data.total;
            } catch (err) { console.error('Error loading stats', err); }
        }

        function playBeep() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator(); const gainNode = audioContext.createGain();
                oscillator.connect(gainNode); gainNode.connect(audioContext.destination);
                oscillator.frequency.value = 1000; oscillator.type = 'sine';
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime); gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
                oscillator.start(audioContext.currentTime); oscillator.stop(audioContext.currentTime + 0.1);
            } catch (e) { }
        }

        setInterval(async () => {
            try {
                const response = await fetch('{{ route('boarding.stats') }}', { method: 'GET', headers: { 'Accept': 'application/json' } });
                if (response.status === 401 || response.status === 419) window.location.href = '{{ route('staff.login') }}';
            } catch (e) {}
        }, 60000);
    </script>
</x-layouts.staff>
