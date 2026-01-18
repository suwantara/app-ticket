<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>E-Ticket #{{ $order->order_number }}</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1e293b;
            background: #fff;
            line-height: 1.3;
        }

        .ticket-page {
            width: 100%;
            height: 277mm;
            /* A4 height minus margins */
            page-break-after: always;
            page-break-inside: avoid;
            display: table;
        }

        .ticket-page:last-child {
            page-break-after: auto;
        }

        .ticket-wrapper {
            display: table-cell;
            vertical-align: middle;
        }

        .ticket-container {
            border: 2px solid #1e3a5f;
            border-radius: 10px;
            overflow: hidden;
            max-width: 100%;
        }

        /* Header */
        .ticket-header {
            background: #1e3a5f;
            color: white;
            padding: 15px 20px;
            position: relative;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .company-tagline {
            font-size: 9px;
            opacity: 0.85;
            margin-top: 2px;
        }

        .ticket-label {
            background: #f59e0b;
            color: #1e3a5f;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            margin-left: 10px;
        }

        .status-used {
            background: #64748b;
            color: white;
        }

        .status-cancelled {
            background: #ef4444;
            color: white;
        }

        /* Route Section */
        .route-section {
            background: #f1f5f9;
            padding: 15px 20px;
            border-bottom: 2px dashed #94a3b8;
        }

        .route-table {
            width: 100%;
            border-collapse: collapse;
        }

        .route-table td {
            vertical-align: middle;
        }

        .port-code {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a5f;
        }

        .port-name {
            font-size: 10px;
            color: #64748b;
        }

        .arrow-cell {
            text-align: center;
            width: 25%;
        }

        .arrow-box {
            background: #1e3a5f;
            color: #f59e0b;
            padding: 6px 16px;
            border-radius: 15px;
            display: inline-block;
            font-size: 14px;
        }

        .duration {
            font-size: 8px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Info Section */
        .info-section {
            padding: 12px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .info-label {
            font-size: 8px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .info-value {
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
        }

        .info-sub {
            font-size: 9px;
            color: #64748b;
            font-weight: normal;
        }

        /* Main Content */
        .main-content {
            border-bottom: 1px solid #e2e8f0;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table td {
            vertical-align: top;
        }

        .passenger-col {
            width: 55%;
            padding: 15px 20px;
            border-right: 2px dashed #94a3b8;
        }

        .qr-col {
            width: 45%;
            padding: 15px 20px;
            text-align: center;
            vertical-align: middle;
        }

        .section-title {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            font-weight: bold;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
        }

        .passenger-name {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a5f;
            margin-bottom: 4px;
        }

        .passenger-id {
            font-size: 10px;
            color: #64748b;
            margin-bottom: 6px;
        }

        .type-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
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

        .highlight-box {
            background: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 5px;
            padding: 8px 10px;
            margin-top: 10px;
        }

        .highlight-text {
            font-size: 9px;
            color: #92400e;
        }

        .highlight-text strong {
            color: #1e3a5f;
        }

        .qr-code img {
            width: 120px;
            height: 120px;
        }

        .ticket-number {
            font-family: 'DejaVu Sans Mono', monospace;
            font-size: 11px;
            font-weight: bold;
            color: #1e3a5f;
            background: #f1f5f9;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 8px;
            letter-spacing: 0.5px;
        }

        .scan-text {
            font-size: 8px;
            color: #94a3b8;
            margin-top: 6px;
        }

        /* Footer */
        .ticket-footer {
            background: #f8fafc;
            padding: 10px 20px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: middle;
            font-size: 9px;
        }

        .order-number {
            font-weight: bold;
            color: #1e3a5f;
        }

        .print-info {
            text-align: right;
            color: #94a3b8;
            font-size: 8px;
        }

        /* Terms */
        .terms-section {
            padding: 10px 20px;
            border-top: 1px solid #e2e8f0;
        }

        .terms-title {
            font-size: 8px;
            font-weight: bold;
            color: #1e3a5f;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .terms-list {
            margin: 0;
            padding-left: 12px;
        }

        .terms-list li {
            font-size: 7px;
            color: #64748b;
            margin-bottom: 1px;
        }

        /* Page Info */
        .page-info {
            text-align: center;
            padding: 8px 0;
            font-size: 8px;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    @foreach ($tickets as $index => $ticket)
        <div class="ticket-page">
            <div class="ticket-wrapper">
                <div class="ticket-container">
                    <!-- Header -->
                    <div class="ticket-header">
                        <table class="header-table">
                            <tr>
                                <td style="width: 70%;">
                                    <div class="company-name">SEMABUHILLS</div>
                                    <div class="company-tagline">Fast Boat Ticket • Nusa Penida & Bali</div>
                                </td>
                                <td style="text-align: right;">
                                    <span class="ticket-label">E-TICKET</span>
                                    @if ($ticket->status !== 'unused')
                                        <span
                                            class="status-badge {{ $ticket->status === 'used' ? 'status-used' : 'status-cancelled' }}">
                                            {{ $ticket->status === 'used' ? 'USED' : 'CANCELLED' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Route Section -->
                    <div class="route-section">
                        <table class="route-table">
                            <tr>
                                <td style="width: 37%;">
                                    <div class="port-code">
                                        {{ strtoupper(substr($order->schedule->route->origin->name, 0, 3)) }}</div>
                                    <div class="port-name">{{ $order->schedule->route->origin->name }}</div>
                                </td>
                                <td class="arrow-cell">
                                    <div class="arrow-box">→</div>
                                    <div class="duration">{{ $order->schedule->route->duration }} menit</div>
                                </td>
                                <td style="width: 37%; text-align: right;">
                                    <div class="port-code">
                                        {{ strtoupper(substr($order->schedule->route->destination->name, 0, 3)) }}</div>
                                    <div class="port-name">{{ $order->schedule->route->destination->name }}</div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Travel Info -->
                    <div class="info-section">
                        <table class="info-table">
                            <tr>
                                <td style="width: 30%;">
                                    <div class="info-label">Tanggal</div>
                                    <div class="info-value">{{ $order->travel_date->translatedFormat('d M Y') }}</div>
                                    <div class="info-sub">{{ $order->travel_date->translatedFormat('l') }}</div>
                                </td>
                                <td style="width: 20%;">
                                    <div class="info-label">Berangkat</div>
                                    <div class="info-value">
                                        {{ \Carbon\Carbon::parse($order->schedule->departure_time)->format('H:i') }}
                                    </div>
                                    <div class="info-sub">WITA</div>
                                </td>
                                <td style="width: 20%;">
                                    <div class="info-label">Tiba</div>
                                    <div class="info-value">
                                        {{ \Carbon\Carbon::parse($order->schedule->arrival_time)->format('H:i') }}
                                    </div>
                                    <div class="info-sub">WITA</div>
                                </td>
                                <td style="width: 30%;">
                                    <div class="info-label">Kapal</div>
                                    <div class="info-value">{{ $order->schedule->ship->name }}</div>
                                    <div class="info-sub">{{ $order->schedule->ship->operator ?? '' }}</div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Main Content -->
                    <div class="main-content">
                        <table class="main-table">
                            <tr>
                                <td class="passenger-col">
                                    <div class="section-title">Data Penumpang</div>
                                    <div class="passenger-name">{{ $ticket->passenger->name }}</div>
                                    <div class="passenger-id">
                                        {{ strtoupper($ticket->passenger->id_type) }}:
                                        {{ $ticket->passenger->id_number }}
                                    </div>
                                    <span class="type-badge type-{{ $ticket->passenger->type }}">
                                        {{ $ticket->passenger->type === 'adult' ? 'Dewasa' : ($ticket->passenger->type === 'child' ? 'Anak' : 'Bayi') }}
                                    </span>

                                    <div class="highlight-box">
                                        <div class="highlight-text">
                                            <strong>Penting:</strong> Hadir di pelabuhan <strong>30 menit</strong>
                                            sebelum keberangkatan. Bawa identitas asli.
                                        </div>
                                    </div>
                                </td>
                                <td class="qr-col">
                                    <div class="section-title">Boarding Pass</div>
                                    <div class="qr-code">
                                        <img src="{{ $ticket->qr_base64 }}" alt="QR">
                                    </div>
                                    <div class="ticket-number">{{ $ticket->ticket_number }}</div>
                                    <div class="scan-text">Scan QR saat boarding</div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="ticket-footer">
                        <table class="footer-table">
                            <tr>
                                <td>
                                    Order: <span class="order-number">{{ $order->order_number }}</span> &bull;
                                    {{ $order->contact_email }}
                                </td>
                                <td class="print-info">
                                    Tiket {{ $index + 1 }}/{{ $tickets->count() }} &bull;
                                    {{ now()->translatedFormat('d M Y H:i') }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Terms -->
                    <div class="terms-section">
                        <div class="terms-title">Syarat & Ketentuan</div>
                        <ul class="terms-list">
                            <li>Tiket berlaku untuk tanggal dan jadwal yang tertera</li>
                            <li>Tiket tidak dapat dipindahtangankan ke orang lain</li>
                            <li>Pembatalan mengikuti kebijakan refund yang berlaku</li>
                        </ul>
                    </div>
                </div>

                <div class="page-info">
                    SemabuHills &bull; semabuhills.com &bull; Halaman {{ $index + 1 }} dari {{ $tickets->count() }}
                </div>
            </div>
        </div>
    @endforeach
</body>

</html>
