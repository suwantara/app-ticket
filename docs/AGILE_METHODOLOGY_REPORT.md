# 📋 Laporan Implementasi Metodologi Agile

## Ferry Ticket Booking System - SemabuHills

**Dibuat:** 19 Januari 2026  
**Project:** App-Ticket (Sistem Pemesanan Tiket Ferry)

---

## 📌 Ringkasan Eksekutif

Project ini dikembangkan menggunakan **Metodologi Agile** dengan pendekatan iteratif dan incremental. Setiap sprint fokus pada delivery fitur yang dapat digunakan oleh end-user.

**Durasi Pengembangan:** 4.5 Bulan (18 Minggu)  
**Periode:** September 2025 - Januari 2026

---

## 👥 Tim Pengembangan

| Role | Nama | Tanggung Jawab |
|------|------|----------------|
| **Project Manager** | - | Koordinasi tim, timeline management, stakeholder communication |
| **System Analyst** | - | Requirements gathering, system design, documentation |
| **UI/UX Designer** | - | Wireframe, mockup, user interface design, usability testing |
| **Programmer** | - | Frontend & backend development, database, API integration |
| **Quality Assurance** | - | Test planning, test execution, bug reporting, regression testing |

### Pembagian Tugas per Sprint

```
Sprint 1-2: System Analyst (lead) + UI/UX Designer
Sprint 3-6: Programmer (lead) + UI/UX Designer  
Sprint 7-9: Programmer + QA (testing phase)
Project Manager: Oversight sepanjang project
```

---

## 1. 📋 PLAN (Perencanaan)

### 1.1 Product Vision

> Membangun sistem pemesanan tiket ferry online yang mudah, aman, dan terintegrasi untuk rute Bali - Nusa Penida, Lembongan, dan Gili Islands.

### 1.2 Product Backlog

| Priority | User Story | Story Points |
|----------|------------|--------------|
| P0 | Sebagai pengguna, saya ingin mencari jadwal kapal | 5 |
| P0 | Sebagai pengguna, saya ingin memesan tiket online | 8 |
| P0 | Sebagai pengguna, saya ingin membayar via online | 13 |
| P0 | Sebagai pengguna, saya ingin menerima e-ticket dengan QR | 8 |
| P1 | Sebagai staff, saya ingin scan QR untuk boarding | 8 |
| P1 | Sebagai admin, saya ingin mengelola jadwal dan kapal | 5 |
| P2 | Sebagai pengguna, saya ingin melihat galeri destinasi | 3 |
| P2 | Sebagai pengguna, saya ingin mengirim pesan kontak | 2 |
| P3 | Sebagai sistem, order expired otomatis jika tidak dibayar | 5 |

### 1.3 Sprint Planning (4.5 Bulan = 9 Sprint)

| Sprint | Minggu | Fokus | Deliverables | PIC |
|--------|--------|-------|--------------|-----|
| Sprint 1 | 1-2 | Discovery & Planning | Requirements, User stories | SA, PM |
| Sprint 2 | 3-4 | Design | Wireframe, UI/UX mockup, Database design | UI/UX, SA |
| Sprint 3 | 5-6 | Core Booking | Search jadwal, Booking form | Programmer |
| Sprint 4 | 7-8 | Payment | Midtrans integration, Order management | Programmer |
| Sprint 5 | 9-10 | E-Ticket | QR Code generation, PDF ticket | Programmer |
| Sprint 6 | 11-12 | Boarding System | QR Scanner, Staff dashboard | Programmer |
| Sprint 7 | 13-14 | Admin Panel | Filament admin, CRUD operations | Programmer |
| Sprint 8 | 15-16 | Testing & QA | Integration testing, UAT, Bug fixes | QA, Programmer |
| Sprint 9 | 17-18 | Deploy & Polish | Performance optimization, Production deploy | All Team |

### 1.4 Timeline Gantt Chart

```
Bulan       | Sep 2025  | Okt 2025  | Nov 2025  | Des 2025  | Jan 2026  |
Minggu      | 1 2 3 4   | 5 6 7 8   | 9 10 11 12| 13 14 15 16| 17 18     |
------------|-----------|-----------|-----------|-----------|-----------|
Discovery   | ████      |           |           |           |           |
Design      |     ████  |           |           |           |           |
Development |           | ████████████████████████████      |           |
Testing     |           |           |           | ████████  |           |
Deployment  |           |           |           |           | ████      |
```

### 1.5 Work Breakdown Structure (WBS)

```
1.0 FERRY TICKET BOOKING SYSTEM
│
├── 1.1 PROJECT INITIATION
│   ├── 1.1.1 Project charter
│   ├── 1.1.2 Stakeholder identification
│   ├── 1.1.3 Requirements gathering
│   └── 1.1.4 Feasibility study
│
├── 1.2 PLANNING & ANALYSIS
│   ├── 1.2.1 System requirements specification
│   ├── 1.2.2 Use case diagram
│   ├── 1.2.3 Activity diagram
│   ├── 1.2.4 Data flow diagram
│   └── 1.2.5 Risk assessment
│
├── 1.3 SYSTEM DESIGN
│   ├── 1.3.1 Database Design
│   │   ├── 1.3.1.1 ERD (Entity Relationship Diagram)
│   │   ├── 1.3.1.2 Table schema design
│   │   └── 1.3.1.3 Migration scripts
│   │
│   ├── 1.3.2 UI/UX Design
│   │   ├── 1.3.2.1 Wireframe homepage
│   │   ├── 1.3.2.2 Wireframe booking flow
│   │   ├── 1.3.2.3 Wireframe admin panel
│   │   ├── 1.3.2.4 Hi-fi mockup
│   │   └── 1.3.2.5 Design system (colors, typography)
│   │
│   └── 1.3.3 Architecture Design
│       ├── 1.3.3.1 System architecture diagram
│       ├── 1.3.3.2 API endpoint design
│       └── 1.3.3.3 Security design
│
├── 1.4 DEVELOPMENT
│   ├── 1.4.1 Backend Development
│   │   ├── 1.4.1.1 Laravel project setup
│   │   ├── 1.4.1.2 Database migrations
│   │   ├── 1.4.1.3 Eloquent models
│   │   ├── 1.4.1.4 Controllers & routes
│   │   ├── 1.4.1.5 Middleware (auth, security)
│   │   └── 1.4.1.6 Services layer
│   │
│   ├── 1.4.2 Frontend Development
│   │   ├── 1.4.2.1 Blade layouts & components
│   │   ├── 1.4.2.2 Livewire components
│   │   ├── 1.4.2.3 Tailwind CSS styling
│   │   ├── 1.4.2.4 JavaScript interactions
│   │   └── 1.4.2.5 Responsive design
│   │
│   ├── 1.4.3 Module: Booking System
│   │   ├── 1.4.3.1 Schedule search
│   │   ├── 1.4.3.2 Booking form (multi-step)
│   │   ├── 1.4.3.3 Passenger data management
│   │   └── 1.4.3.4 Order creation
│   │
│   ├── 1.4.4 Module: Payment
│   │   ├── 1.4.4.1 Midtrans integration
│   │   ├── 1.4.4.2 Payment callback handler
│   │   ├── 1.4.4.3 Order status management
│   │   └── 1.4.4.4 Auto-expiration system
│   │
│   ├── 1.4.5 Module: E-Ticket
│   │   ├── 1.4.5.1 Ticket generation service
│   │   ├── 1.4.5.2 QR code generation
│   │   ├── 1.4.5.3 PDF ticket generation
│   │   └── 1.4.5.4 Email notification (optional)
│   │
│   ├── 1.4.6 Module: Boarding System
│   │   ├── 1.4.6.1 Staff authentication
│   │   ├── 1.4.6.2 QR scanner interface
│   │   ├── 1.4.6.3 Ticket validation API
│   │   └── 1.4.6.4 Boarding statistics
│   │
│   └── 1.4.7 Module: Admin Panel
│       ├── 1.4.7.1 Filament setup
│       ├── 1.4.7.2 Destination management
│       ├── 1.4.7.3 Schedule management
│       ├── 1.4.7.4 Order management
│       ├── 1.4.7.5 Gallery management
│       └── 1.4.7.6 Message management
│
├── 1.5 TESTING
│   ├── 1.5.1 Unit Testing
│   │   ├── 1.5.1.1 Model tests
│   │   └── 1.5.1.2 Service tests
│   │
│   ├── 1.5.2 Feature Testing
│   │   ├── 1.5.2.1 Authentication tests
│   │   ├── 1.5.2.2 Booking flow tests
│   │   ├── 1.5.2.3 Payment tests
│   │   ├── 1.5.2.4 Ticket validation tests
│   │   └── 1.5.2.5 API endpoint tests
│   │
│   ├── 1.5.3 Integration Testing
│   │   ├── 1.5.3.1 Midtrans sandbox testing
│   │   └── 1.5.3.2 End-to-end flow testing
│   │
│   ├── 1.5.4 UAT (User Acceptance Testing)
│   │   ├── 1.5.4.1 UAT scenario preparation
│   │   ├── 1.5.4.2 UAT execution
│   │   └── 1.5.4.3 Bug fixing
│   │
│   └── 1.5.5 Performance Testing
│       ├── 1.5.5.1 Load testing
│       └── 1.5.5.2 Lighthouse audit
│
├── 1.6 DEPLOYMENT
│   ├── 1.6.1 Environment Setup
│   │   ├── 1.6.1.1 Heroku configuration
│   │   ├── 1.6.1.2 Database setup (ClearDB)
│   │   ├── 1.6.1.3 Environment variables
│   │   ├── 1.6.1.4 SSL certificate
│   │
│   ├── 1.6.2 Production Deployment
│   │   ├── 1.6.2.1 Code deployment
│   │   ├── 1.6.2.2 Database migration
│   │   ├── 1.6.2.3 Storage configuration
│   │   └── 1.6.2.4 Scheduler setup
│   │
│   └── 1.6.3 Post-Deployment
│       ├── 1.6.3.1 Smoke testing
│       ├── 1.6.3.2 Monitoring setup
│       └── 1.6.3.3 Documentation update
│
└── 1.7 PROJECT CLOSURE
    ├── 1.7.1 Final documentation
    ├── 1.7.2 User training
    ├── 1.7.3 Handover
    └── 1.7.4 Project retrospective
```

#### WBS Dictionary (Deskripsi Singkat)

| WBS Code | Task Name | Deskripsi | Durasi | PIC |
|----------|-----------|-----------|--------|-----|
| 1.1 | Project Initiation | Inisiasi dan perencanaan awal project | 1 minggu | PM, SA |
| 1.2 | Planning & Analysis | Analisis kebutuhan dan dokumentasi | 1 minggu | SA |
| 1.3 | System Design | Perancangan database, UI/UX, arsitektur | 2 minggu | SA, UI/UX |
| 1.4 | Development | Pengembangan seluruh modul aplikasi | 10 minggu | Programmer |
| 1.5 | Testing | Pengujian unit, integration, UAT | 2 minggu | QA |
| 1.6 | Deployment | Deploy ke production dan konfigurasi | 1 minggu | Programmer |
| 1.7 | Project Closure | Dokumentasi final dan handover | 1 minggu | All Team |

### 1.6 Anggaran Proyek

> **Catatan:** Anggaran ini disusun berdasarkan standar **Software House Menengah** di Indonesia untuk sistem booking dengan integrasi payment gateway, e-ticket, dan multi-role management.

#### Tabel 1: Anggaran Sumber Daya Manusia (SDM)

| No | Peran | Durasi | Biaya/Bulan | Total |
|----|-------|--------|-------------|-------|
| 1 | Project Manager | 4,5 bulan | Rp 12.000.000 | Rp 54.000.000 |
| 2 | System Analyst | 2,5 bulan | Rp 10.000.000 | Rp 25.000.000 |
| 3 | UI/UX Designer | 3 bulan | Rp 9.000.000 | Rp 27.000.000 |
| 4 | Fullstack Developer | 4 bulan | Rp 15.000.000 | Rp 60.000.000 |
| 5 | QA Engineer | 2,5 bulan | Rp 8.000.000 | Rp 20.000.000 |
| | **Total SDM** | | | **Rp 186.000.000** |

#### Tabel 2: Anggaran Kegiatan Agile dan Manajemen Proyek

| No | Kegiatan | Frekuensi | Biaya | Total |
|----|----------|-----------|-------|-------|
| 1 | Sprint Planning | 9 kali | Rp 500.000 | Rp 4.500.000 |
| 2 | Daily Scrum | 90 kali | Rp 100.000 | Rp 9.000.000 |
| 3 | Sprint Review | 9 kali | Rp 500.000 | Rp 4.500.000 |
| 4 | Sprint Retrospective | 9 kali | Rp 300.000 | Rp 2.700.000 |
| | **Subtotal** | | | **Rp 20.700.000** |

#### Tabel 3: Anggaran Tools dan Software Pendukung

| No | Kebutuhan | Jenis | Durasi | Biaya |
|----|-----------|-------|--------|-------|
| 1 | Project Management Tool (Jira) | Langganan | 5 bulan | Rp 3.500.000 |
| 2 | Repository Source Code (GitHub Team) | Langganan | 5 bulan | Rp 2.500.000 |
| 3 | UI/UX Design Tool (Figma Pro) | Langganan | 5 bulan | Rp 5.000.000 |
| 4 | IDE & Development Tools | Lisensi | 5 bulan | Rp 2.000.000 |
| | **Subtotal** | | | **Rp 13.000.000** |

#### Tabel 4: Anggaran Infrastruktur Sistem

| No | Kebutuhan | Biaya |
|----|-----------|-------|
| 1 | Server VPS Development & Staging | Rp 6.000.000 |
| 2 | Server Production (Heroku/AWS) | Rp 12.000.000 |
| 3 | Domain, SSL, dan CDN | Rp 2.000.000 |
| | **Subtotal** | **Rp 20.000.000** |

#### Tabel 5: Anggaran Pengujian Sistem

| No | Jenis Pengujian | Biaya |
|----|-----------------|-------|
| 1 | Functional Testing per Sprint | Rp 5.000.000 |
| 2 | User Acceptance Test (UAT) | Rp 5.000.000 |
| 3 | Performance & Load Testing | Rp 3.000.000 |
| 4 | Security Audit | Rp 5.000.000 |
| | **Subtotal** | **Rp 18.000.000** |

#### Tabel 6: Anggaran Dokumentasi dan Pelaporan

| No | Dokumen | Biaya |
|----|---------|-------|
| 1 | Software Requirements Specification (SRS) | Rp 3.000.000 |
| 2 | Sprint Reports (9 sprint) | Rp 2.000.000 |
| 3 | User Manual & Training Guide | Rp 3.000.000 |
| 4 | Technical Documentation | Rp 3.000.000 |
| 5 | Laporan Akhir Proyek | Rp 2.000.000 |
| | **Subtotal** | **Rp 13.000.000** |

#### Tabel 7: Cadangan Risiko dan Perubahan (~15%)

| No | Keterangan | Biaya |
|----|------------|-------|
| 1 | Perubahan scope & penambahan fitur | Rp 15.000.000 |
| 2 | Revisi desain dan bug fixing | Rp 10.000.000 |
| | **Subtotal** | **Rp 25.000.000** |

#### Tabel 8: Biaya Tak Terduga (Contingency ~10%)

| No | Keterangan | Biaya |
|----|------------|-------|
| 1 | Buffer untuk risiko tidak terduga | Rp 30.000.000 |
| | **Subtotal** | **Rp 30.000.000** |

---

#### Rekapitulasi Total Anggaran Proyek

| No | Kategori | Subtotal |
|----|----------|----------|
| 1 | Sumber Daya Manusia (5 orang) | Rp 186.000.000 |
| 2 | Kegiatan Agile & Manajemen | Rp 20.700.000 |
| 3 | Tools & Software | Rp 13.000.000 |
| 4 | Infrastruktur Sistem | Rp 20.000.000 |
| 5 | Pengujian Sistem | Rp 18.000.000 |
| 6 | Dokumentasi & Pelaporan | Rp 13.000.000 |
| 7 | Cadangan Risiko (15%) | Rp 25.000.000 |
| 8 | Biaya Tak Terduga (10%) | Rp 30.000.000 |
| | **TOTAL ANGGARAN PROYEK** | **Rp 325.700.000** |

#### Perbandingan dengan Standar Industri

| Kategori Vendor | Range Harga | Posisi Budget Ini |
|-----------------|-------------|-------------------|
| Freelancer | Rp 50 - 100 juta | - |
| Software House Kecil | Rp 150 - 250 juta | - |
| **Software House Menengah** | **Rp 250 - 400 juta** | **✓ Rp 325.7 juta** |
| Enterprise | Rp 400 juta+ | - |

| Keterangan | Nilai |
|------------|-------|
| Budget Awal | Rp 400.000.000 |
| Total Anggaran | Rp 325.700.000 |
| **Sisa Budget** | **Rp 74.300.000** |

### 1.4 Tech Stack Decision

```
┌─────────────────────────────────────────────────────────────┐
│                      FRONTEND                                │
│  Tailwind CSS 4.0  │  Flowbite  │  Alpine.js (via Livewire) │
└─────────────────────────────────────────────────────────────┘
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                      BACKEND                                 │
│      Laravel 12.x   │   Livewire 4.0   │   Filament 5.0     │
└─────────────────────────────────────────────────────────────┘
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                    EXTERNAL SERVICES                         │
│     Midtrans    │    Cloudinary    │       Heroku           │
└─────────────────────────────────────────────────────────────┘
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                      DATABASE                                │
│                      MySQL 8.x                               │
└─────────────────────────────────────────────────────────────┘
```

---

## 2. 🎨 DESIGN (Perancangan)

### 2.1 Database Design

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ Destination │◄────│    Route    │────►│ Destination │
│  (origin)   │     │             │     │(destination)│
└──────┬──────┘     └──────┬──────┘     └─────────────┘
       │                   │
       ▼                   ▼
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│GalleryImage │     │  Schedule   │────►│    Ship     │
└─────────────┘     └──────┬──────┘     └─────────────┘
                           │
                           ▼
                    ┌─────────────┐
                    │    Order    │◄──── User (optional)
                    └──────┬──────┘
                           │
              ┌────────────┼────────────┐
              ▼                         ▼
       ┌─────────────┐           ┌─────────────┐
       │  Passenger  │◄──────────│   Ticket    │
       └─────────────┘           └─────────────┘
```

### 2.2 Application Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                      PRESENTATION LAYER                      │
│  Blade Views  │  Livewire Components  │  Tailwind CSS       │
└─────────────────────────────────────────────────────────────┘
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                      APPLICATION LAYER                       │
│  Controllers  │  Livewire  │  Middleware  │  Filament       │
└─────────────────────────────────────────────────────────────┘
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                       SERVICE LAYER                          │
│ MidtransService │ TicketService │ QrCodeService │ CacheService│
└─────────────────────────────────────────────────────────────┘
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                         DATA LAYER                           │
│        Eloquent Models    │     Observers     │    Factories │
└─────────────────────────────────────────────────────────────┘
```

### 2.3 User Flow Design

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│  Homepage   │───►│ Search Form │───►│   Results   │
└─────────────┘    └─────────────┘    └──────┬──────┘
                                             │
      ┌──────────────────────────────────────┘
      ▼
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│Booking Form │───►│   Payment   │───►│  E-Ticket   │
│(Multi-step) │    │  (Midtrans) │    │  (QR Code)  │
└─────────────┘    └─────────────┘    └─────────────┘
```

### 2.4 UI/UX Principles

- **Mobile-First**: Responsive design untuk semua device
- **Minimalist**: UI bersih dengan fokus pada konversi
- **Accessible**: WCAG-compliant color contrast
- **Fast**: Lazy loading, preconnect hints, deferred scripts

---

## 3. 💻 DEVELOP (Pengembangan)

### 3.1 Sprint 1: Core Booking System

**Deliverables:**
- ✅ Database schema & migrations
- ✅ Models: Destination, Route, Ship, Schedule
- ✅ Livewire SearchBookingForm component
- ✅ Schedule search API endpoint
- ✅ Basic booking flow UI

**Key Files Created:**
```
app/Models/
├── Destination.php
├── Route.php
├── Ship.php
├── Schedule.php
└── Order.php

app/Livewire/
├── SearchBookingForm.php
└── ScheduleSection.php
```

**Implementasi Model Destination:**
```php
class Destination extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'description',
        'coordinates', 'image_url', 'is_active'
    ];

    // Relasi ke Route (sebagai origin)
    public function routesAsOrigin()
    {
        return $this->hasMany(Route::class, 'origin_id');
    }

    // Relasi ke Route (sebagai destination)
    public function routesAsDestination()
    {
        return $this->hasMany(Route::class, 'destination_id');
    }

    // Relasi ke Gallery Images
    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
```

### 3.2 Sprint 2: Payment Integration

**Deliverables:**
- ✅ Midtrans Snap integration
- ✅ Order & Passenger models
- ✅ Multi-step BookingForm
- ✅ E-Ticket generation
- ✅ QR Code generation

**Key Files Created:**
```
app/Services/
├── MidtransService.php
├── TicketService.php
├── QrCodeService.php
└── TicketPdfService.php

app/Http/Controllers/
├── PaymentController.php
└── TicketPdfController.php
```

**Implementasi MidtransService:**
```php
class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createSnapToken(Order $order): array
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->contact_name,
                'email' => $order->contact_email,
                'phone' => $order->contact_phone,
            ],
            'item_details' => $this->getItemDetails($order),
        ];

        $snapToken = Snap::getSnapToken($params);
        return ['snap_token' => $snapToken];
    }
}
```

**Implementasi TicketService:**
```php
class TicketService
{
    public function generateTicketsForOrder(Order $order): array
    {
        $tickets = [];
        
        foreach ($order->passengers as $passenger) {
            $ticket = Ticket::create([
                'order_id' => $order->id,
                'passenger_id' => $passenger->id,
                'ticket_number' => $this->generateTicketNumber(),
                'qr_code' => $this->generateQrCode(),
                'status' => 'active',
            ]);
            $tickets[] = $ticket;
        }

        return ['success' => true, 'tickets' => $tickets];
    }

    private function generateTicketNumber(): string
    {
        return 'TKT' . date('Ymd') . strtoupper(Str::random(5));
    }
}
```

### 3.3 Sprint 3: Boarding System

**Deliverables:**
- ✅ Staff authentication
- ✅ QR Scanner interface
- ✅ Ticket validation API
- ✅ Boarding statistics dashboard

**Key Files Created:**
```
app/Http/Controllers/
├── BoardingController.php
├── StaffAuthController.php
└── TicketController.php

app/Services/
├── TicketValidationService.php
└── BoardingStatsService.php
```

**Implementasi TicketValidationService:**
```php
class TicketValidationService
{
    public function validateTicket(string $qrCode): array
    {
        $ticket = Ticket::where('qr_code', $qrCode)->first();

        if (!$ticket) {
            return ['valid' => false, 'message' => 'Tiket tidak ditemukan'];
        }

        if ($ticket->status === 'used') {
            return [
                'valid' => false,
                'message' => 'Tiket sudah digunakan',
                'used_at' => $ticket->used_at,
            ];
        }

        if ($ticket->status === 'cancelled') {
            return ['valid' => false, 'message' => 'Tiket telah dibatalkan'];
        }

        // Check travel date
        if ($ticket->order->travel_date !== now()->format('Y-m-d')) {
            return [
                'valid' => false,
                'message' => 'Tiket tidak valid untuk hari ini',
                'travel_date' => $ticket->order->travel_date,
            ];
        }

        return [
            'valid' => true,
            'message' => 'Tiket valid',
            'ticket' => $ticket->load(['passenger', 'order.schedule.route']),
        ];
    }

    public function useTicket(Ticket $ticket, ?string $usedBy = null): array
    {
        $ticket->update([
            'status' => 'used',
            'used_at' => now(),
            'used_by' => $usedBy,
        ]);

        return ['success' => true, 'message' => 'Tiket berhasil digunakan'];
    }
}
```

### 3.4 Sprint 4: Admin Panel & Polish

**Deliverables:**
- ✅ Filament Admin Panel
- ✅ Gallery management
- ✅ Contact form & Message management
- ✅ Auto-expiration command

**Key Files Created:**
```
app/Filament/Admin/Resources/
├── DestinationResource.php
├── ScheduleResource.php
├── OrderResource.php
├── GalleryImageResource.php
└── MessageResource.php

app/Console/Commands/
└── ExpireUnpaidOrders.php
```

**Implementasi ExpireUnpaidOrders Command:**
```php
class ExpireUnpaidOrders extends Command
{
    protected $signature = 'orders:expire-unpaid';
    protected $description = 'Expire unpaid orders after 30 minutes';

    public function handle()
    {
        $expiredOrders = Order::where('payment_status', 'unpaid')
            ->where('created_at', '<', now()->subMinutes(30))
            ->where('status', '!=', 'expired')
            ->get();

        foreach ($expiredOrders as $order) {
            $order->update([
                'status' => 'expired',
                'payment_status' => 'expired',
            ]);

            // Restore available seats
            $order->schedule->increment(
                'available_seats',
                $order->passenger_count
            );

            $this->info("Order {$order->order_number} expired.");
        }

        $this->info("Total: {$expiredOrders->count()} orders expired.");
    }
}
```

### 3.5 Sprint 5: Optimization & Deploy

**Deliverables:**
- ✅ Performance optimization (preconnect, defer, lazy load)
- ✅ Heroku deployment configuration
- ✅ Production caching setup
- ✅ Documentation updates

**Optimisasi yang Dilakukan:**
```html
<!-- Preconnect untuk resource eksternal -->
<link rel="preconnect" href="https://res.cloudinary.com" crossorigin>
<link rel="preconnect" href="https://ka-f.fontawesome.com" crossorigin>
<link rel="dns-prefetch" href="https://images.unsplash.com">

<!-- FontAwesome di-defer untuk menghindari blocking -->
<script src="https://kit.fontawesome.com/xxx.js" defer></script>
```

**Lazy Loading untuk Gambar:**
```html
<img src="{{ $imageUrl }}"
     loading="lazy"
     width="400"
     height="192"
     alt="{{ $destination->name }}" />
```

---

## 4. 🧪 TEST (Pengujian)

### 4.1 Testing Strategy

| Test Type | Framework | Coverage |
|-----------|-----------|----------|
| Unit Tests | Pest PHP | Services, Helpers |
| Feature Tests | Pest PHP | Controllers, API |
| Integration Tests | Pest PHP | Full flows |
| Manual Testing | Browser | UI/UX validation |

### 4.2 Test Suites

```bash
tests/Feature/
├── AuthenticationTest.php      # 4 tests  - Login, Register, Logout
├── AutoBoardingTest.php        # 5 tests  - QR Scan, Validation
├── BookingFlowTest.php         # 8 tests  - Full booking process
├── GalleryTest.php             # 6 tests  - Gallery CRUD
├── GalleryRouteTest.php        # 3 tests  - Gallery routing
├── GallerySimpleTest.php       # 3 tests  - Basic gallery
├── QrTicketTest.php            # 7 tests  - QR & ticket validation
├── ScheduleSearchTest.php      # 5 tests  - Schedule search API
├── UserManagementTest.php      # 6 tests  - User CRUD
└── ImageCompressionServiceTest.php # 3 tests - Image processing
```

### 4.3 Contoh Test Case: Booking Flow

```php
test('can create order with passengers', function () {
    $order = Order::create([
        'order_number' => 'TKT' . date('Ymd') . 'TEST1',
        'schedule_id' => $this->schedule->id,
        'travel_date' => Carbon::tomorrow()->format('Y-m-d'),
        'contact_name' => 'John Doe',
        'contact_email' => 'john@example.com',
        'contact_phone' => '081234567890',
        'passenger_count' => 2,
        'total_amount' => 300000,
        'status' => 'pending',
        'payment_status' => 'pending',
    ]);

    Passenger::create([
        'order_id' => $order->id,
        'name' => 'John Doe',
        'id_type' => 'ktp',
        'id_number' => '1234567890123456',
        'age_group' => 'adult',
        'price' => 150000,
    ]);

    expect($order->passengers)->toHaveCount(1);
    expect($order->total_amount)->toBe(300000);
});

test('can generate tickets after payment', function () {
    // Create and pay order
    $order = Order::create([...]);
    $order->update([
        'payment_status' => 'paid',
        'status' => 'confirmed',
    ]);

    // Generate tickets
    $ticketService = app(TicketService::class);
    $result = $ticketService->generateTicketsForOrder($order);

    expect($result['success'])->toBeTrue();
    expect($result['tickets'][0]->status)->toBe('active');
    expect($result['tickets'][0]->qr_code)->not->toBeNull();
});
```

### 4.4 Contoh Test Case: QR Ticket Validation

```php
test('validates active ticket correctly', function () {
    $ticket = Ticket::factory()->create(['status' => 'active']);

    $service = app(TicketValidationService::class);
    $result = $service->validateTicket($ticket->qr_code);

    expect($result['valid'])->toBeTrue();
    expect($result['message'])->toBe('Tiket valid');
});

test('rejects already used ticket', function () {
    $ticket = Ticket::factory()->create([
        'status' => 'used',
        'used_at' => now(),
    ]);

    $service = app(TicketValidationService::class);
    $result = $service->validateTicket($ticket->qr_code);

    expect($result['valid'])->toBeFalse();
    expect($result['message'])->toContain('sudah digunakan');
});
```

### 4.5 Test Results

```
   PASS  Tests\Feature\AuthenticationTest
  ✓ user can login with correct credentials
  ✓ user cannot login with incorrect credentials
  ✓ user can register new account
  ✓ user can logout

   PASS  Tests\Feature\BookingFlowTest
  ✓ can create order with passengers
  ✓ can generate tickets after payment
  ✓ ticket has correct passenger information
  ✓ order total is calculated correctly
  ✓ schedule available seats decrease after booking
  ✓ booking page redirects to login without authentication
  ✓ can view ticket with order number

   PASS  Tests\Feature\QrTicketTest
  ✓ validates active ticket correctly
  ✓ rejects already used ticket
  ✓ rejects cancelled ticket
  ✓ rejects ticket for wrong travel date
  ✓ can mark ticket as used
  ✓ generates valid QR code content
  ✓ QR code contains ticket information

   PASS  Tests\Feature\ScheduleSearchTest
  ✓ can search schedules by route and date
  ✓ returns empty for unavailable routes
  ✓ filters by passenger count
  ✓ excludes fully booked schedules
  ✓ returns correct price information

  Tests:    48 passed (148 assertions)
  Duration: 8.42s
```

### 4.6 Code Quality Metrics

| Metric | Tool | Status | Details |
|--------|------|--------|---------|
| Code Style | Laravel Pint | ✅ Passing | PSR-12 compliant |
| Static Analysis | PHPStan | ✅ Level 5 | No errors |
| Type Safety | PHP 8.2 | ✅ Strict | Type declarations |
| Test Coverage | Pest | ✅ ~60% | Core flows covered |

### 4.7 Manual Testing Checklist

| Scenario | Status | Notes |
|----------|--------|-------|
| Search jadwal dari homepage | ✅ Pass | Livewire reactive |
| Pilih jadwal dan isi data | ✅ Pass | Multi-step form |
| Proses pembayaran Midtrans | ✅ Pass | Sandbox tested |
| Terima e-ticket dengan QR | ✅ Pass | PDF download ok |
| Scan QR di boarding | ✅ Pass | Real-time validation |
| Admin kelola jadwal | ✅ Pass | Filament CRUD |
| Admin kelola galeri | ✅ Pass | Cloudinary upload |
| Contact form submit | ✅ Pass | Email validation |

---

## 5. 🚀 DEPLOY (Deployment)

### 5.1 Deployment Environment

| Environment | Platform | URL |
|-------------|----------|-----|
| Development | Laragon (Local) | http://app-ticket.test |
| Production | Heroku | https://app-tickets-244be60c2a8e.herokuapp.com |

### 5.2 CI/CD Pipeline

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│  Git Push   │───►│   GitHub    │───►│   Heroku    │
│  (main)     │    │   Actions   │    │   Deploy    │
└─────────────┘    └─────────────┘    └─────────────┘
        │                 │                  │
        ▼                 ▼                  ▼
   Code Review      Run Tests          Auto Deploy
```

### 5.3 Deployment Checklist

**Pre-deployment:**
```bash
✅ php artisan test                    # Semua test pass
✅ npm run build                       # Build production assets
✅ php artisan config:clear            # Clear config cache
✅ Update .env.production              # Environment variables
✅ git push origin main                # Push to repository
```

**Post-deployment:**
```bash
✅ heroku run php artisan migrate --force
✅ heroku run php artisan optimize
✅ heroku run php artisan storage:link
✅ Configure Heroku Scheduler for orders:expire-unpaid
✅ Verify application health
```

### 5.4 Production Configuration

**Procfile:**
```
web: vendor/bin/heroku-php-apache2 public/
```

**Heroku Add-ons:**
```
├── ClearDB MySQL (Ignite plan)
├── Heroku Scheduler (Free)
├── Papertrail (Free - logging)
└── Heroku SSL (Auto)
```

### 5.5 Environment Variables (Production)

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://app-tickets-244be60c2a8e.herokuapp.com

# Database (ClearDB)
DB_CONNECTION=mysql
CLEARDB_DATABASE_URL=mysql://user:pass@host/db

# Midtrans (Production)
MIDTRANS_IS_PRODUCTION=true
MIDTRANS_SERVER_KEY=Mid-server-xxx
MIDTRANS_CLIENT_KEY=Mid-client-xxx

# Cloudinary
CLOUDINARY_URL=cloudinary://xxx:xxx@cloud

# Session
SESSION_DRIVER=database
CACHE_DRIVER=file
```

### 5.6 Scheduled Tasks (Heroku Scheduler)

| Task | Frequency | Command |
|------|-----------|---------|
| Expire unpaid orders | Every 10 min | `php artisan orders:expire-unpaid` |



---

## 6. 🔍 REVIEW (Evaluasi)

### 6.1 Sprint Retrospective Summary

| Sprint | What Went Well | What to Improve |
|--------|---------------|-----------------|
| 1 | Fast Livewire setup | Need more unit tests |
| 2 | Midtrans integration smooth | Error handling edge cases |
| 3 | QR Scanner works great | Staff UX can be improved |
| 4 | Filament saved dev time | Gallery needs optimization |
| 5 | Heroku deploy successful | Performance needs work |

### 6.2 Performance Metrics

| Metric | Before Optimization | After Optimization | Target |
|--------|--------------------|--------------------|--------|
| FCP | 5.7s | ~2.0s | < 1.8s |
| LCP | 28.3s | ~4.0s | < 2.5s |
| TBT | 6,260ms | ~500ms | < 200ms |

### 6.3 Completed Features

| Feature | Status | Notes |
|---------|--------|-------|
| Schedule Search | ✅ Done | Livewire reactive |
| Online Booking | ✅ Done | Multi-step form |
| Midtrans Payment | ✅ Done | All methods supported |
| E-Ticket QR | ✅ Done | PDF download |
| Boarding System | ✅ Done | Staff dashboard |
| Admin Panel | ✅ Done | Filament 5.0 |
| Gallery | ✅ Done | Cloudinary storage |
| Contact Form | ✅ Done | Message management |
| Auto-expiration | ✅ Done | 30 min timeout |
| Performance Opt. | ✅ Done | Preconnect, defer, lazy |

### 6.4 Technical Debt

| Item | Priority | Status |
|------|----------|--------|
| Convert images to WebP | High | Manual conversion needed |
| Implement Redis caching | Medium | Using file cache |
| Add more unit tests | Medium | Coverage ~60% |
| Implement rate limiting | Low | Basic implementation |

### 6.5 Future Improvements (Backlog)

- [ ] Email notifications (order confirmation, reminder)
- [ ] Multi-language support (ID/EN)
- [ ] Mobile app (React Native)
- [ ] Loyalty program
- [ ] Dynamic pricing engine

---

## 📊 Conclusion

Project **Ferry Ticket Booking System** berhasil dikembangkan menggunakan metodologi Agile dengan 5 sprint. Semua fitur core telah selesai dan sistem sudah live di production (Heroku).

**Key Achievements:**
- 📱 Sistem booking end-to-end yang fungsional
- 💳 Integrasi payment gateway (Midtrans)
- 🎫 E-Ticket dengan QR Code
- 🔐 Boarding system dengan validasi real-time
- ⚙️ Admin panel lengkap (Filament)
- ✅ 48 automated tests passing

---

*Dokumen ini dibuat sebagai bagian dari dokumentasi project menggunakan metodologi Agile.*
