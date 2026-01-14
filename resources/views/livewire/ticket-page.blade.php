<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">E-Ticket</h1>
            <p class="text-gray-600 dark:text-gray-400">Order #{{ $order->order_number }}</p>
        </div>

        {{-- Loading State --}}
        <div wire:loading.flex wire:target="checkPaymentStatus" class="justify-center items-center py-12">
            <x-ui.spinner size="lg" />
            <span class="ml-3 text-gray-600 dark:text-gray-400">Memverifikasi pembayaran...</span>
        </div>

        <div wire:loading.remove wire:target="checkPaymentStatus">
            {{-- Success Alert --}}
            @if($order->isPaid())
                <x-ui.alert type="success" class="mb-6">
                    <div>
                        <span class="font-medium">Pembayaran Berhasil!</span>
                        Tiket Anda sudah aktif dan siap digunakan.
                    </div>
                </x-ui.alert>
            @endif

            {{-- Error Message --}}
            @if($errorMessage)
                <x-ui.alert type="danger" dismissible class="mb-6">
                    {{ $errorMessage }}
                </x-ui.alert>
            @endif

            {{-- Success Message --}}
            @if($successMessage)
                <x-ui.alert type="success" dismissible class="mb-6">
                    {{ $successMessage }}
                </x-ui.alert>
            @endif

            {{-- Trip Info Card --}}
            <div class="mb-6">
                <x-ticket.trip-info :order="$order" />
            </div>

            {{-- Tickets Section --}}
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Tiket Penumpang ({{ $order->tickets->count() }})
                    </h2>
                    <button wire:click="refreshTickets"
                            wire:loading.attr="disabled"
                            class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center gap-1">
                        <svg wire:loading.class="animate-spin" wire:target="refreshTickets" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Refresh</span>
                    </button>
                </div>

                @foreach($order->tickets as $index => $ticket)
                    <div id="ticket-{{ $ticket->id }}">
                        <x-ticket.card :ticket="$ticket" :index="$index" />
                    </div>
                @endforeach
            </div>

            {{-- Important Notice --}}
            <x-ui.alert type="warning" class="mt-8">
                <div>
                    <span class="font-medium">Penting!</span>
                    <ul class="mt-1.5 list-disc list-inside text-sm">
                        <li>Tunjukkan QR Code saat boarding</li>
                        <li>Harap tiba di pelabuhan minimal 30 menit sebelum keberangkatan</li>
                        <li>Bawa identitas asli sesuai data yang didaftarkan</li>
                        <li>Tiket tidak dapat dipindahtangankan</li>
                    </ul>
                </div>
            </x-ui.alert>

            {{-- Actions --}}
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <x-ui.button :href="route('home')" color="secondary">
                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Kembali ke Beranda
                </x-ui.button>

                <x-ui.button wire:click="downloadPdf" color="danger">
                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF
                </x-ui.button>

                <x-ui.button :href="route('booking.form')" color="primary">
                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Pesan Tiket Lagi
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Print Handler Script --}}
    @script
    <script>
        $wire.on('print-ticket', (event) => {
            const ticketId = event.ticketId;
            const ticket = document.getElementById(ticketId);
            if (!ticket) return;

            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Print Ticket</title>
                    <script src="https://cdn.tailwindcss.com"><\/script>
                    <style>
                        @media print {
                            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                        }
                    </style>
                </head>
                <body class="p-8 bg-white">
                    ${ticket.innerHTML}
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.onload = function() {
                setTimeout(() => printWindow.print(), 250);
            };
        });
    </script>
    @endscript
</div>
