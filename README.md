# 🚢 Ferry Ticket Booking System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire">
  <img src="https://img.shields.io/badge/Filament-4.x-FDAE4B?style=for-the-badge&logo=filament&logoColor=white" alt="Filament">
  <img src="https://img.shields.io/badge/Tailwind-4.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Tests-23%20passed-success?style=flat-square" alt="Tests">
  <img src="https://img.shields.io/badge/Assertions-64-blue?style=flat-square" alt="Assertions">
  <img src="https://img.shields.io/badge/License-Proprietary-red?style=flat-square" alt="License">
</p>

Sistem pemesanan tiket ferry online untuk rute **Bali - Nusa Penida, Lembongan, dan Gili Islands**. Dilengkapi dengan pembayaran online via Midtrans, E-Ticket dengan QR Code, dan sistem boarding.

---

## ✨ Fitur Utama

| Fitur | Deskripsi |
|-------|-----------|
| 🔍 **Pencarian Jadwal** | Cari jadwal kapal berdasarkan rute, tanggal, dan jumlah penumpang |
| 🎫 **Pemesanan Online** | Multi-step booking dengan data penumpang |
| 💳 **Pembayaran Midtrans** | VA Bank, E-Wallet (GoPay, ShopeePay), Credit Card |
| 📱 **E-Ticket QR Code** | Tiket digital dengan QR code untuk boarding |
| 📄 **PDF Download** | Download tiket dalam format PDF |
| 🔐 **Boarding System** | QR Scanner untuk validasi tiket di pelabuhan |
| ⚙️ **Admin Panel** | Kelola jadwal, kapal, rute, pesanan via Filament |
| 📝 **CMS Pages** | Halaman dinamis untuk About, Contact, dll |

---

## 🛠️ Tech Stack

### Backend
- **PHP 8.2+** - Server-side language
- **Laravel 12** - PHP Framework
- **Livewire 3** - Reactive components tanpa page reload
- **Filament 4** - Admin panel
- **MySQL 8** - Database

### Frontend
- **Tailwind CSS 4** - Utility-first CSS framework
- **Flowbite** - UI Component library
- **Alpine.js** - Lightweight JavaScript (via Livewire)
- **Vite 7** - Build tool

### External Services
- **Midtrans** - Payment gateway
- **SimpleSoftwareIO/QrCode** - QR code generation
- **DomPDF** - PDF generation

---

## 📋 Requirements

- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x
- MySQL >= 8.0
- SSL Certificate (required untuk Midtrans production)

---

## 🚀 Installation

### 1. Clone Repository
```bash
git clone https://github.com/suwantara/app-ticket.git
cd app-ticket
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ferry_ticket
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Configure Midtrans
```env
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false
```

### 6. Run Migrations & Seeders
```bash
php artisan migrate
php artisan db:seed
```

### 7. Build Assets
```bash
npm run build
# atau untuk development
npm run dev
```

### 8. Create Storage Link
```bash
php artisan storage:link
```

### 9. Start Server
```bash
php artisan serve
```

Akses aplikasi di: `http://127.0.0.1:8000`

---

## 🔑 Default Accounts

### Admin Panel
```
URL: http://127.0.0.1:8000/admin
```
Buat admin account via tinker:
```bash
php artisan tinker
>>> App\Models\User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('password'),'role'=>'admin'])
```

### Staff (Boarding)
```
URL: http://127.0.0.1:8000/staff/login
```

---

## 📁 Project Structure

```
app-ticket/
├── app/
│   ├── Filament/Admin/      # Admin panel resources
│   ├── Http/Controllers/    # HTTP Controllers
│   ├── Livewire/           # Livewire components
│   │   ├── BookingForm.php
│   │   ├── SearchBookingForm.php
│   │   └── TicketPage.php
│   ├── Models/             # Eloquent models
│   └── Services/           # Business logic
│       ├── MidtransService.php
│       └── TicketService.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
│   ├── components/         # Blade components
│   │   ├── ui/            # Reusable UI (alert, badge, button, card)
│   │   └── ticket/        # Ticket components
│   ├── livewire/          # Livewire views
│   └── pages/             # Page templates
├── routes/
│   └── web.php            # Web routes
└── tests/
    ├── Feature/           # Feature tests
    └── Unit/              # Unit tests
```

---

## 🧪 Testing

### Run All Tests
```bash
php artisan test
```

### Run Specific Test
```bash
php artisan test --filter=BookingFlowTest
```

### Test Results
```
✓ Tests:    23 passed
✓ Assertions: 64
✓ Duration: ~17s
```

| Test Suite | Tests |
|------------|-------|
| BookingFlowTest | 7 |
| QrTicketTest | 8 |
| ScheduleSearchTest | 6 |
| ExampleTest | 2 |

---

## 🔌 API Endpoints

### Schedule Search
```http
GET /schedules/search?origin_id=1&destination_id=5&date=2026-01-04&passengers=2
```

### Ticket Validation
```http
GET /api/ticket/validate/{qrCode}
```

### Mark Ticket as Used
```http
POST /api/ticket/use/{ticket}
```

Dokumentasi lengkap: [ARCHITECTURE.md](ARCHITECTURE.md)

---

## 💳 Payment Flow

```
Booking → Payment Page → Midtrans Snap → Callback → Generate Ticket → E-Ticket Page
```

### Supported Payment Methods
- 💳 Credit/Debit Card (Visa, Mastercard)
- 🏦 Bank Transfer (BCA, BNI, BRI, Mandiri, Permata)
- 📱 E-Wallet (GoPay, ShopeePay, DANA, OVO)
- 🏪 Retail (Alfamart, Indomaret)

---

## 🚢 Available Routes

| Route | From | To | Duration |
|-------|------|-----|----------|
| SAN-NP | Sanur | Nusa Penida | 45 min |
| SAN-NL | Sanur | Nusa Lembongan | 30 min |
| SAN-GT | Sanur | Gili Trawangan | 2.5 hours |
| PB-GT | Padang Bai | Gili Trawangan | 1.5 hours |
| PB-GA | Padang Bai | Gili Air | 1.5 hours |

---

## 🔒 Security Features

- ✅ CSRF Protection
- ✅ IDOR Prevention (menggunakan order_number bukan ID)
- ✅ Input Validation
- ✅ Payment Verification via Midtrans API
- ✅ Secure PDF Token Generation
- ✅ Role-based Access Control

---

## 📚 Documentation

- [ARCHITECTURE.md](ARCHITECTURE.md) - Dokumentasi arsitektur lengkap
- [MVP_DOCUMENTATION.md](MVP_DOCUMENTATION.md) - Dokumentasi MVP

---

## 🤝 Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📄 License

This project is proprietary software. All rights reserved.

---

## 👨‍💻 Author

**Suwantara**

---

<p align="center">
  Made with ❤️ in Bali, Indonesia
</p>
