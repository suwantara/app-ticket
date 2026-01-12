<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>E-Ticket #{{ $order->order_number }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            background: #f0f4f8;
        }

        .ticket-page {
            width: 100%;
            min-height: 100vh;
            padding: 20px;
            page-break-after: always;
            background: #f0f4f8;
        }

        .ticket-page:last-child {
            page-break-after: auto;
        }

        .ticket-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .ticket-header {
            background: linear-gradient(135deg, #0066cc 0%, #0099ff 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .company-tagline {
            font-size: 11px;
            opacity: 0.9;
        }

        .ticket-type {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 15px;
            border-radius: 20px;
            margin-top: 10px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Route Section */
        .route-section {
            background: #f8fafc;
            padding: 25px;
            text-align: center;
            border-bottom: 2px dashed #e2e8f0;
        }

        .route-container {
            display: table;
            width: 100%;
        }

        .route-point {
            display: table-cell;
            width: 35%;
            vertical-align: middle;
        }

        .route-arrow {
            display: table-cell;
            width: 30%;
            vertical-align: middle;
            text-align: center;
        }

        .port-code {
            font-size: 28px;
            font-weight: bold;
            color: #0066cc;
        }

        .port-name {
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
        }

        .arrow-icon {
            font-size: 24px;
            color: #0066cc;
        }

        .travel-duration {
            font-size: 10px;
            color: #94a3b8;
            margin-top: 5px;
        }

        /* Info Grid */
        .info-grid {
            padding: 20px 25px;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-cell {
            display: table-cell;
            width: 50%;
            padding-right: 10px;
        }

        .info-label {
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
        }

        .info-value-small {
            font-size: 12px;
            font-weight: normal;
            color: #475569;
        }

        /* Passenger Section */
        .passenger-section {
            padding: 20px 25px;
            background: #f8fafc;
            border-bottom: 2px dashed #e2e8f0;
        }

        .section-title {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            font-weight: bold;
        }

        .passenger-name {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .passenger-id {
            font-size: 12px;
            color: #64748b;
        }

        .passenger-type-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 8px;
        }

        .type-adult {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .type-child {
            background: #fef3c7;
            color: #d97706;
        }

        .type-infant {
            background: #fce7f3;
            color: #db2777;
        }

        /* QR Section */
        .qr-section {
            padding: 25px;
            text-align: center;
        }

        .qr-code {
            margin: 0 auto 15px;
        }

        .qr-code img, .qr-code svg {
            width: 150px;
            height: 150px;
        }

        .ticket-number {
            font-family: 'DejaVu Sans Mono', monospace;
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
            background: #f1f5f9;
            padding: 8px 15px;
            border-radius: 8px;
            display: inline-block;
            letter-spacing: 1px;
        }

        .qr-instruction {
            font-size: 10px;
            color: #94a3b8;
            margin-top: 10px;
        }

        /* Footer */
        .ticket-footer {
            background: #1e293b;
            color: white;
            padding: 15px 25px;
            font-size: 10px;
        }

        .footer-row {
            display: table;
            width: 100%;
        }

        .footer-cell {
            display: table-cell;
            width: 50%;
        }

        .footer-cell.right {
            text-align: right;
        }

        .order-number {
            font-weight: bold;
            font-size: 11px;
        }

        /* Terms */
        .terms-section {
            padding: 20px 25px;
            background: #fff;
            border-top: 1px solid #e2e8f0;
        }

        .terms-title {
            font-size: 10px;
            font-weight: bold;
            color: #64748b;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .terms-list {
            font-size: 9px;
            color: #94a3b8;
            line-height: 1.5;
        }

        .terms-list li {
            margin-bottom: 3px;
            list-style-position: inside;
        }

        /* Status Badge */
        .status-badge {
            position: absolute;
            top: 80px;
            right: 25px;
            background: #22c55e;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-used {
            background: #94a3b8;
        }

        .status-cancelled {
            background: #ef4444;
        }

        /* Page Number */
        .page-info {
            text-align: center;
            padding: 15px;
            font-size: 10px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    @foreach($tickets as $index => $ticket)
    <div class="ticket-page">
        <div class="ticket-container">
            <!-- Header -->
            <div class="ticket-header" style="position: relative;">
                <div class="company-name">🚢 KAPAL CEPAT</div>
                <div class="company-tagline">Fast Boat Ticket - Bali & Nusa Penida</div>
                <div class="ticket-type">E-Ticket / Boarding Pass</div>
                @if($ticket->status !== 'unused')
                <div class="status-badge {{ $ticket->status === 'used' ? 'status-used' : ($ticket->status === 'cancelled' ? 'status-cancelled' : '') }}">
                    {{ $ticket->status === 'used' ? 'SUDAH DIGUNAKAN' : ($ticket->status === 'cancelled' ? 'DIBATALKAN' : strtoupper($ticket->status)) }}
                </div>
                @endif
            </div>

            <!-- Route Section -->
            <div class="route-section">
                <div class="route-container">
                    <div class="route-point" style="text-align: left;">
                        <div class="port-code">{{ strtoupper(substr($order->schedule->route->origin->name, 0, 3)) }}</div>
                        <div class="port-name">{{ $order->schedule->route->origin->name }}</div>
                    </div>
                    <div class="route-arrow">
                        <div class="arrow-icon">→</div>
                        <div class="travel-duration">{{ $order->schedule->route->duration }} menit</div>
                    </div>
                    <div class="route-point" style="text-align: right;">
                        <div class="port-code">{{ strtoupper(substr($order->schedule->route->destination->name, 0, 3)) }}</div>
                        <div class="port-name">{{ $order->schedule->route->destination->name }}</div>
                    </div>
                </div>
            </div>

            <!-- Travel Info -->
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Tanggal Keberangkatan</div>
                        <div class="info-value">{{ $order->travel_date->translatedFormat('l, d F Y') }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Jam Keberangkatan</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($order->schedule->departure_time)->format('H:i') }} WIB</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Kapal</div>
                        <div class="info-value">{{ $order->schedule->ship->name }}</div>
                        <div class="info-value-small">{{ $order->schedule->ship->operator ?? 'Fast Boat' }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Estimasi Tiba</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($order->schedule->arrival_time)->format('H:i') }} WIB</div>
                    </div>
                </div>
            </div>

            <!-- Passenger Section -->
            <div class="passenger-section">
                <div class="section-title">Data Penumpang</div>
                <div class="passenger-name">{{ $ticket->passenger->name }}</div>
                <div class="passenger-id">
                    {{ strtoupper($ticket->passenger->id_type) }}: {{ $ticket->passenger->id_number }}
                </div>
                <span class="passenger-type-badge type-{{ $ticket->passenger->type }}">
                    {{ $ticket->passenger->type === 'adult' ? 'Dewasa' : ($ticket->passenger->type === 'child' ? 'Anak-anak' : 'Bayi') }}
                </span>
            </div>

            <!-- QR Code Section -->
            <div class="qr-section">
                <div class="qr-code">
                    <img src="{{ $ticket->qr_base64 }}" alt="QR Code" style="width: 150px; height: 150px;">
                </div>
                <div class="ticket-number">{{ $ticket->ticket_number }}</div>
                <div class="qr-instruction">Tunjukkan QR code ini saat boarding</div>
            </div>

            <!-- Footer -->
            <div class="ticket-footer">
                <div class="footer-row">
                    <div class="footer-cell">
                        <div class="order-number">Order: {{ $order->order_number }}</div>
                        <div>{{ $order->contact_email }}</div>
                    </div>
                    <div class="footer-cell right">
                        <div>Dicetak: {{ now()->translatedFormat('d M Y H:i') }}</div>
                        <div>Tiket {{ $index + 1 }} dari {{ $tickets->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Terms -->
            <div class="terms-section">
                <div class="terms-title">Syarat & Ketentuan</div>
                <ul class="terms-list">
                    <li>Hadir di pelabuhan minimal 30 menit sebelum keberangkatan</li>
                    <li>Tunjukkan e-ticket dan identitas yang valid saat check-in</li>
                    <li>Tiket tidak dapat dipindahtangankan</li>
                    <li>Pembatalan tiket mengikuti kebijakan yang berlaku</li>
                </ul>
            </div>
        </div>

        <div class="page-info">
            Halaman {{ $index + 1 }} dari {{ $tickets->count() }} • {{ config('app.name', 'Kapal Cepat') }}
        </div>
    </div>
    @endforeach
</body>
</html>
