# 📚 DOKUMENTASI UAS TEKNOLOGI INFORMASI PARIWISATA (TIP)

## Sistem Pemesanan Tiket Ferry Online - SemabuHills
### Rute: Bali - Nusa Penida - Lembongan - Gili Islands

---

# BAGIAN 1: DOKUMENTASI SISTEM

## 1.1 Latar Belakang

Industri pariwisata di Bali, khususnya sektor transportasi laut menuju pulau-pulau kecil seperti Nusa Penida, Nusa Lembongan, dan Gili Islands mengalami pertumbuhan signifikan. Namun, sistem pemesanan tiket masih banyak yang dilakukan secara manual, menyebabkan:

- **Antrian panjang** di pelabuhan
- **Ketidakpastian ketersediaan** kursi
- **Proses pembayaran** yang tidak efisien
- **Kesulitan validasi** tiket saat boarding

Berdasarkan kondisi tersebut, dikembangkan **Sistem Pemesanan Tiket Ferry Online** yang memanfaatkan teknologi informasi untuk meningkatkan pengalaman wisatawan.

## 1.2 Tujuan Sistem

1. Menyediakan platform pemesanan tiket ferry **online 24/7**
2. Mengintegrasikan **pembayaran digital** (e-payment)
3. Menghasilkan **e-ticket dengan QR Code** untuk validasi otomatis
4. Menyediakan **dashboard admin** untuk pengelolaan jadwal dan kapasitas
5. Mempercepat proses **boarding** dengan sistem scan QR

## 1.3 Ruang Lingkup Sistem

| Modul | Deskripsi |
|-------|-----------|
| Modul Pencarian Jadwal | Pencarian jadwal berdasarkan rute, tanggal, dan jumlah penumpang |
| Modul Pemesanan | Multi-step booking form dengan input data penumpang |
| Modul Pembayaran | Integrasi dengan Midtrans payment gateway |
| Modul E-Ticket | Generate tiket digital dengan QR Code unik |
| Modul Boarding | Scanner QR untuk validasi tiket saat masuk kapal |
| Modul Admin | Panel administrasi untuk kelola data master |

## 1.4 Pengguna Sistem

| Role | Akses | Fungsi |
|------|-------|--------|
| **Guest** | Public | Melihat jadwal dan destinasi |
| **User** | Login | Booking tiket, lihat pesanan, download e-ticket |
| **Staff** | Login | Scan QR, validasi boarding, lihat statistik |
| **Admin** | Filament | Kelola semua data master dan transaksi |

---

# BAGIAN 2: PROSES PENGUMPULAN DATA

## 2.1 Metodologi Pengumpulan Data

Pengumpulan data dilakukan menggunakan beberapa metode untuk mendapatkan informasi yang komprehensif:

### 2.1.1 Observasi Langsung

**Lokasi:** Pelabuhan Sanur, Pelabuhan Nusa Penida, Pelabuhan Padang Bai

**Aspek yang Diamati:**
- Proses pembelian tiket manual di loket
- Alur antrian penumpang
- Proses boarding dan pengecekan tiket
- Kondisi fisik tiket dan manifest penumpang
- Waktu yang dibutuhkan untuk setiap proses

**Hasil Observasi:**
| Proses | Waktu Manual | Target Digital |
|--------|--------------|----------------|
| Beli tiket di loket | 5-10 menit | 2-3 menit |
| Antri pembayaran | 10-15 menit | 0 menit (online) |
| Validasi tiket boarding | 30-60 detik | 3-5 detik |
| Rekap data penumpang | 30 menit | Real-time |

### 2.1.2 Wawancara

**Narasumber:**
1. **Operator Kapal** - PT. Semabu Hills Transport
2. **Petugas Loket** - Pelabuhan Sanur
3. **Wisatawan** - Domestik dan Mancanegara

**Pertanyaan Kunci:**
- Apa kendala utama dalam sistem tiket saat ini?
- Fitur apa yang paling dibutuhkan?
- Bagaimana proses ideal menurut Anda?

**Temuan Utama:**
1. Wisatawan menginginkan **booking online** sebelum ke pelabuhan
2. Operator membutuhkan **data real-time** ketersediaan kursi
3. Petugas menginginkan **validasi cepat** tanpa pengecekan manual

### 2.1.3 Studi Literatur dan Benchmarking

**Referensi Sistem:**
- Traveloka (booking tiket)
- Tiket.com (e-ticket system)
- Gojek/Grab (QR code payment)
- Boarding pass pesawat (e-ticket design)

**Best Practices yang Diadopsi:**
1. Multi-step booking wizard
2. Real-time seat availability
3. QR Code untuk validasi instan
4. Email/WhatsApp notification
5. Mobile-responsive design

### 2.1.4 Analisis Dokumen

**Dokumen yang Dianalisis:**
- Tiket ferry fisik (format data)
- Manifest penumpang (field yang diperlukan)
- Laporan penjualan harian
- Jadwal operasional kapal

**Data yang Diekstrak:**

```
┌─────────────────────────────────────────────────────────────────┐
│                    STRUKTUR DATA TIKET                          │
├─────────────────────────────────────────────────────────────────┤
│ • Kode Booking (unik)                                           │
│ • Nama Penumpang                                                │
│ • Nomor Identitas (KTP/Passport)                                │
│ • Rute (Asal - Tujuan)                                          │
│ • Tanggal Keberangkatan                                         │
│ • Jam Keberangkatan                                             │
│ • Nama Kapal                                                    │
│ • Nomor Kursi (opsional)                                        │
│ • Harga Tiket                                                   │
│ • Status Pembayaran                                             │
│ • Tanggal Pembelian                                             │
└─────────────────────────────────────────────────────────────────┘
```

## 2.2 Hasil Pengumpulan Data

### 2.2.1 Data Master yang Diperlukan

| Entitas | Atribut Utama | Sumber Data |
|---------|---------------|-------------|
| **Destinasi** | nama, deskripsi, lokasi, gambar | Observasi + Web |
| **Rute** | asal, tujuan, jarak, durasi | Operator kapal |
| **Kapal** | nama, kapasitas, fasilitas | Operator kapal |
| **Jadwal** | tanggal, jam, harga, kursi_tersedia | Operator kapal |
| **Penumpang** | nama, identitas, kontak | Input user |
| **Order** | kode, total, status, waktu | Generated sistem |
| **Tiket** | qr_code, status_boarding | Generated sistem |

### 2.2.2 Identifikasi Kebutuhan Fungsional

| ID | Kebutuhan | Prioritas |
|----|-----------|-----------|
| F01 | Pencarian jadwal berdasarkan rute dan tanggal | Tinggi |
| F02 | Pemesanan tiket dengan data penumpang lengkap | Tinggi |
| F03 | Pembayaran online via berbagai metode | Tinggi |
| F04 | Generate e-ticket dengan QR Code | Tinggi |
| F05 | Validasi tiket via scan QR | Tinggi |
| F06 | Dashboard admin untuk kelola data | Sedang |
| F07 | Laporan penjualan dan statistik | Sedang |
| F08 | Notifikasi email/WhatsApp | Rendah |

### 2.2.3 Identifikasi Kebutuhan Non-Fungsional

| ID | Kebutuhan | Spesifikasi |
|----|-----------|-------------|
| NF01 | Performa | Response time < 3 detik |
| NF02 | Keamanan | HTTPS, autentikasi, validasi input |
| NF03 | Ketersediaan | Uptime 99.5% |
| NF04 | Skalabilitas | Handle 1000+ transaksi/hari |
| NF05 | Kompatibilitas | Mobile responsive |
| NF06 | Usability | Mudah digunakan tanpa training |

---

# BAGIAN 3: RENCANA IMPLEMENTASI

## 3.1 Arsitektur Sistem yang Direncanakan

```
┌─────────────────────────────────────────────────────────────────────────┐
│                           ARSITEKTUR SISTEM                              │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│   ┌─────────────┐     ┌─────────────┐     ┌─────────────┐               │
│   │   Browser   │     │   Mobile    │     │   Scanner   │               │
│   │   (User)    │     │   (User)    │     │   (Staff)   │               │
│   └──────┬──────┘     └──────┬──────┘     └──────┬──────┘               │
│          │                   │                   │                       │
│          └───────────────────┼───────────────────┘                       │
│                              │                                           │
│                              ▼                                           │
│   ┌──────────────────────────────────────────────────────────────┐      │
│   │                    FRONTEND LAYER                             │      │
│   │         Blade Templates + Livewire + Tailwind CSS            │      │
│   └──────────────────────────┬───────────────────────────────────┘      │
│                              │                                           │
│                              ▼                                           │
│   ┌──────────────────────────────────────────────────────────────┐      │
│   │                    BACKEND LAYER                              │      │
│   │                    Laravel 12.x                               │      │
│   │  ┌────────────┐  ┌────────────┐  ┌────────────────────────┐  │      │
│   │  │ Controllers│  │  Services  │  │   Filament Admin       │  │      │
│   │  │            │  │            │  │                        │  │      │
│   │  │ - Booking  │  │ - Midtrans │  │ - Destination Resource │  │      │
│   │  │ - Payment  │  │ - Ticket   │  │ - Schedule Resource    │  │      │
│   │  │ - Boarding │  │ - QR Code  │  │ - Order Resource       │  │      │
│   │  │ - Ticket   │  │ - PDF      │  │ - User Resource        │  │      │
│   │  └────────────┘  └────────────┘  └────────────────────────┘  │      │
│   └──────────────────────────┬───────────────────────────────────┘      │
│                              │                                           │
│                              ▼                                           │
│   ┌──────────────────────────────────────────────────────────────┐      │
│   │                    DATABASE LAYER                             │      │
│   │                      MySQL 8.x                                │      │
│   │                                                               │      │
│   │  users │ destinations │ routes │ ships │ schedules │ orders  │      │
│   │  passengers │ tickets │ galleries │ messages                   │      │
│   └──────────────────────────────────────────────────────────────┘      │
│                              │                                           │
│                              ▼                                           │
│   ┌──────────────────────────────────────────────────────────────┐      │
│   │                  EXTERNAL SERVICES                            │      │
│   │                                                               │      │
│   │  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────┐   │      │
│   │  │  Midtrans   │  │ Cloudinary  │  │      Heroku         │   │      │
│   │  │  (Payment)  │  │  (Images)   │  │     (Hosting)       │   │      │
│   │  └─────────────┘  └─────────────┘  └─────────────────────┘   │      │
│   └──────────────────────────────────────────────────────────────┘      │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

## 3.2 Teknologi yang Digunakan

| Layer | Teknologi | Versi | Alasan Pemilihan |
|-------|-----------|-------|------------------|
| **Frontend** | Blade + Livewire | 4.0 | Reactive tanpa kompleksitas SPA |
| **CSS** | Tailwind CSS | 4.0 | Utility-first, cepat develop |
| **UI Components** | Flowbite | 2.x | Komponen siap pakai |
| **Backend** | Laravel | 12.x | Framework PHP terpopuler |
| **Admin Panel** | Filament | 5.0 | Admin builder cepat |
| **Database** | MySQL | 8.x | RDBMS stabil dan scalable |
| **Payment** | Midtrans | - | Payment gateway Indonesia |
| **Image CDN** | Cloudinary | - | Optimasi gambar otomatis |
| **Hosting** | Heroku | - | PaaS mudah deployment |

## 3.3 Tahapan Implementasi

| Fase | Sprint | Durasi | Kegiatan | Output |
|------|--------|--------|----------|--------|
| **1. Analysis** | - | 2 minggu | Pengumpulan data, requirement | SRS Document |
| **2. Design** | 1-2 | 4 minggu | Database, UI/UX, arsitektur | ERD, Wireframe, DFD |
| **3. Development** | 3-7 | 10 minggu | Coding semua modul | Aplikasi |
| **4. Testing** | 8 | 2 minggu | Unit test, UAT, bug fixing | Test Report |
| **5. Deployment** | 9 | 2 minggu | Hosting, konfigurasi, go-live | Production System |

## 3.4 Modul yang Diimplementasikan

### Sprint 1-2: Core Foundation
- Setup Laravel project
- Database migration
- Authentication system
- Homepage dan navigasi

### Sprint 3-4: Booking System
- Pencarian jadwal (Livewire)
- Form booking multi-step
- Manajemen penumpang
- Review pesanan

### Sprint 5: Payment Integration
- Integrasi Midtrans Snap
- Handling callback
- Status pembayaran
- Auto-expiration order

### Sprint 6: E-Ticket System
- Generate tiket setelah bayar
- QR Code generation
- PDF ticket download
- Halaman view ticket

### Sprint 7: Boarding System
- Halaman scanner staff
- Validasi QR via API
- Update status boarding
- Statistik boarding

### Sprint 8: Admin Panel
- Filament setup
- CRUD Destinasi, Jadwal, Kapal
- Manajemen Order
- Dashboard statistik

### Sprint 9: Testing & Deployment
- Unit & Feature testing
- User Acceptance Test
- Performance optimization
- Deploy ke Heroku

---

# BAGIAN 4: SYSTEM FLOW DIAGRAM

## 4.1 Definisi

**System Flow Diagram** menggambarkan alur proses dalam sistem secara keseluruhan, menunjukkan bagaimana data mengalir antar komponen sistem dan interaksi antara pengguna dengan sistem.

## 4.2 System Flow - Alur Utama Sistem

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    SYSTEM FLOW DIAGRAM - ALUR UTAMA                      │
│                 Sistem Pemesanan Tiket Ferry Online                      │
└─────────────────────────────────────────────────────────────────────────┘

     ┌─────────┐
     │  START  │
     └────┬────┘
          │
          ▼
    ┌───────────┐
    │   User    │
    │  Akses    │
    │  Website  │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐      Tidak        ┌───────────┐
    │   Cari    │ ──────────────▶   │  Tampil   │
    │  Jadwal   │    Ditemukan      │  "Tidak   │
    │   ?       │                   │   Ada"    │
    └─────┬─────┘                   └─────┬─────┘
          │ Ya                            │
          ▼                               │
    ┌───────────┐                         │
    │  Pilih    │ ◀───────────────────────┘
    │  Jadwal   │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐      Tidak        ┌───────────┐
    │   Sudah   │ ──────────────▶   │   Login   │
    │  Login?   │                   │  / Daftar │
    └─────┬─────┘                   └─────┬─────┘
          │ Ya                            │
          ◀───────────────────────────────┘
          │
          ▼
    ┌───────────┐
    │   Input   │
    │   Data    │
    │ Penumpang │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐
    │  Review   │
    │  Pesanan  │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐
    │   Proses  │
    │ Pembayaran│────────────────────────┐
    │ (Midtrans)│                        │
    └─────┬─────┘                        │
          │                              │
          ▼                              ▼
    ┌───────────┐                  ┌───────────┐
    │ Berhasil  │      Gagal/      │   Order   │
    │   Bayar   │ ◀── Timeout ──── │  Expired  │
    │    ?      │                  │           │
    └─────┬─────┘                  └───────────┘
          │ Ya
          ▼
    ┌───────────┐
    │  Generate │
    │  E-Ticket │
    │  + QR     │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐
    │  Tampil   │
    │  E-Ticket │
    │  ke User  │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐
    │   User    │
    │ Download  │
    │   PDF     │
    └─────┬─────┘
          │
          ▼
     ┌─────────┐
     │   END   │
     └─────────┘
```

## 4.3 System Flow - Proses Boarding

```
┌─────────────────────────────────────────────────────────────────────────┐
│                 SYSTEM FLOW DIAGRAM - PROSES BOARDING                    │
└─────────────────────────────────────────────────────────────────────────┘

     ┌─────────┐
     │  START  │
     └────┬────┘
          │
          ▼
    ┌───────────┐
    │   Staff   │
    │   Login   │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐
    │   Buka    │
    │  Scanner  │
    │   Page    │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐
    │   User    │
    │ Tunjukkan │
    │ QR Tiket  │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐
    │   Scan    │
    │ QR Code   │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐
    │  Kirim    │
    │  Request  │
    │ ke Server │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐
    │  Validasi │──────────────────┬─────────────────┐
    │  Tiket    │                  │                 │
    └─────┬─────┘                  │                 │
          │                        │                 │
          │ Valid                  │ Sudah           │ Tidak
          │                        │ Digunakan       │ Ditemukan
          ▼                        ▼                 ▼
    ┌───────────┐           ┌───────────┐     ┌───────────┐
    │  Update   │           │  Tampil   │     │  Tampil   │
    │  Status   │           │   ERROR   │     │   ERROR   │
    │ = USED    │           │  "USED"   │     │ "INVALID" │
    └─────┬─────┘           └─────┬─────┘     └─────┬─────┘
          │                       │                 │
          ▼                       │                 │
    ┌───────────┐                 │                 │
    │  Tampil   │                 │                 │
    │  SUCCESS  │                 │                 │
    │ + Data    │                 │                 │
    │ Penumpang │                 │                 │
    └─────┬─────┘                 │                 │
          │                       │                 │
          ▼                       ▼                 ▼
    ┌───────────┐           ┌───────────┐     ┌───────────┐
    │  Izinkan  │           │   Tolak   │     │   Tolak   │
    │ Boarding  │           │ Boarding  │     │ Boarding  │
    └─────┬─────┘           └─────┬─────┘     └─────┬─────┘
          │                       │                 │
          └───────────────────────┼─────────────────┘
                                  │
                                  ▼
                            ┌─────────┐
                            │   END   │
                            └─────────┘
```

## 4.4 System Flow - Panel Admin

```
┌─────────────────────────────────────────────────────────────────────────┐
│                   SYSTEM FLOW DIAGRAM - ADMIN PANEL                      │
└─────────────────────────────────────────────────────────────────────────┘

     ┌─────────┐
     │  START  │
     └────┬────┘
          │
          ▼
    ┌───────────┐
    │   Admin   │
    │   Login   │
    │  Filament │
    └─────┬─────┘
          │
          ▼
    ┌───────────┐
    │ Dashboard │
    │ Overview  │
    └─────┬─────┘
          │
          ▼
    ┌───────────────────────────────────────────────────┐
    │              PILIH MENU                            │
    └───────┬───────────┬───────────┬───────────┬───────┘
            │           │           │           │
            ▼           ▼           ▼           ▼
      ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐
      │Destinasi│ │ Jadwal  │ │  Order  │ │  User   │
      │ Master  │ │ Master  │ │ Manage  │ │ Manage  │
      └────┬────┘ └────┬────┘ └────┬────┘ └────┬────┘
           │           │           │           │
           ▼           ▼           ▼           ▼
      ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐
      │  CRUD   │ │  CRUD   │ │  View/  │ │  CRUD   │
      │Destinasi│ │ Jadwal  │ │ Update  │ │  Users  │
      └────┬────┘ └────┬────┘ └────┬────┘ └────┬────┘
           │           │           │           │
           └───────────┴───────────┴───────────┘
                              │
                              ▼
                        ┌─────────┐
                        │   END   │
                        └─────────┘
```

---

# BAGIAN 5: DOCUMENT FLOW DIAGRAM

## 5.1 Definisi

**Document Flow Diagram** menggambarkan alur dokumen (baik fisik maupun digital) yang mengalir antar entitas dalam sistem. Diagram ini menunjukkan dokumen apa saja yang dihasilkan, siapa yang membuat, dan ke mana dokumen tersebut dikirim.

## 5.2 Document Flow - Pemesanan Tiket

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                        DOCUMENT FLOW DIAGRAM                                     │
│                   Proses Pemesanan Tiket Ferry Online                            │
└─────────────────────────────────────────────────────────────────────────────────┘

┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐
│     PENGGUNA     │  │      SISTEM      │  │      STAFF       │  │      ADMIN       │
│     (User)       │  │    (Aplikasi)    │  │    (Boarding)    │  │    (Filament)    │
└────────┬─────────┘  └────────┬─────────┘  └────────┬─────────┘  └────────┬─────────┘
         │                     │                     │                     │
         │  ┌─────────────┐    │                     │                     │
         │  │ Form        │    │                     │                     │
         │  │ Pencarian   │    │                     │                     │
         │  │ Jadwal      │    │                     │                     │
         │  └──────┬──────┘    │                     │                     │
         │         │           │                     │                     │
         │         ▼           │                     │                     │
         │  ───────────────▶   │                     │                     │
         │                     │  ┌─────────────┐    │                     │
         │                     │  │ Query       │    │                     │
         │                     │  │ Database    │    │                     │
         │                     │  │ Jadwal      │    │                     │
         │                     │  └──────┬──────┘    │                     │
         │                     │         │           │                     │
         │                     │         ▼           │                     │
         │  ◀───────────────   │  ┌─────────────┐    │                     │
         │                     │  │ Data        │    │                     │
         │  ┌─────────────┐    │  │ Jadwal      │    │                     │
         │  │ Daftar      │    │  │ Tersedia    │    │                     │
         │  │ Jadwal      │◀───│  └─────────────┘    │                     │
         │  │ Tersedia    │    │                     │                     │
         │  └──────┬──────┘    │                     │                     │
         │         │           │                     │                     │
         │         ▼           │                     │                     │
         │  ┌─────────────┐    │                     │                     │
         │  │ Form        │    │                     │                     │
         │  │ Data        │    │                     │                     │
         │  │ Penumpang   │    │                     │                     │
         │  └──────┬──────┘    │                     │                     │
         │         │           │                     │                     │
         │         ▼           │                     │                     │
         │  ───────────────▶   │                     │                     │
         │                     │  ┌─────────────┐    │                     │
         │                     │  │ Simpan      │    │                     │
         │                     │  │ Order &     │    │                     │
         │                     │  │ Passengers  │    │                     │
         │                     │  └──────┬──────┘    │                     │
         │                     │         │           │                     │
         │                     │         ▼           │                     │
         │                     │  ┌─────────────┐    │                     │
         │                     │  │ Request     │    │                     │
         │                     │  │ Snap Token  │───▶│ MIDTRANS            │
         │                     │  │ ke Midtrans │    │                     │
         │                     │  └──────┬──────┘    │                     │
         │                     │         │           │                     │
         │  ◀───────────────   │  ◀──────┘           │                     │
         │                     │                     │                     │
         │  ┌─────────────┐    │                     │                     │
         │  │ Popup       │    │                     │                     │
         │  │ Pembayaran  │    │                     │                     │
         │  │ Midtrans    │    │                     │                     │
         │  └──────┬──────┘    │                     │                     │
         │         │           │                     │                     │
         │         ▼           │                     │                     │
         │  ┌─────────────┐    │                     │                     │
         │  │ Bukti       │    │                     │                     │
         │  │ Pembayaran  │────▶                     │                     │
         │  └─────────────┘    │                     │                     │
         │                     │  ┌─────────────┐    │                     │
         │                     │  │ Callback    │    │                     │
         │                     │  │ dari        │◀───│ MIDTRANS            │
         │                     │  │ Midtrans    │    │                     │
         │                     │  └──────┬──────┘    │                     │
         │                     │         │           │                     │
         │                     │         ▼           │                     │
         │                     │  ┌─────────────┐    │                     │
         │                     │  │ Update      │    │                     │
         │                     │  │ Status      │    │                     │
         │                     │  │ = PAID      │    │                     │
         │                     │  └──────┬──────┘    │                     │
         │                     │         │           │                     │
         │                     │         ▼           │                     │
         │                     │  ┌─────────────┐    │                     │
         │                     │  │ Generate    │    │                     │
         │                     │  │ Tiket       │    │                     │
         │                     │  │ + QR Code   │    │                     │
         │                     │  └──────┬──────┘    │                     │
         │                     │         │           │                     │
         │  ◀───────────────   │  ◀──────┘           │                     │
         │                     │                     │                     │
         │  ┌─────────────┐    │                     │                     │
         │  │ ═══════════ │    │                     │                     │
         │  │ E-TICKET    │    │                     │                     │
         │  │ ─────────── │    │                     │                     │
         │  │ Order: #123 │    │                     │                     │
         │  │ Nama: John  │    │                     │                     │
         │  │ Rute: SNR-NP│    │                     │                     │
         │  │ Tgl: 20 Jan │    │                     │                     │
         │  │ ┌─────────┐ │    │                     │                     │
         │  │ │ QR CODE │ │    │                     │                     │
         │  │ │  █████  │ │    │                     │                     │
         │  │ │  █████  │ │    │                     │                     │
         │  │ └─────────┘ │    │                     │                     │
         │  │ ═══════════ │    │                     │                     │
         │  └──────┬──────┘    │                     │                     │
         │         │           │                     │                     │
         │         │           │                     │                     │
         │  ═══════════════════╪════════ HARI H ═════╪═════════════════    │
         │         │           │                     │                     │
         │         ▼           │                     │                     │
         │  ┌─────────────┐    │                     │                     │
         │  │ Tunjukkan   │    │                     │                     │
         │  │ QR Code     │────│─────────────────────▶                     │
         │  │ di HP       │    │                     │  ┌─────────────┐    │
         │  └─────────────┘    │                     │  │ Scan QR     │    │
         │                     │                     │  │ dengan      │    │
         │                     │                     │  │ Kamera      │    │
         │                     │                     │  └──────┬──────┘    │
         │                     │                     │         │           │
         │                     │                     │         ▼           │
         │                     │  ◀──────────────────│  ┌─────────────┐    │
         │                     │                     │  │ Request     │    │
         │                     │  ┌─────────────┐    │  │ Validasi    │    │
         │                     │  │ Validasi    │    │  │ ke Server   │    │
         │                     │  │ Tiket di    │    │  └─────────────┘    │
         │                     │  │ Database    │    │                     │
         │                     │  └──────┬──────┘    │                     │
         │                     │         │           │                     │
         │                     │         ▼           │                     │
         │                     │  ┌─────────────┐    │                     │
         │                     │  │ Update      │    │                     │
         │                     │  │ Status      │    │                     │
         │                     │  │ = USED      │    │                     │
         │                     │  └──────┬──────┘    │                     │
         │                     │         │           │                     │
         │                     │  ───────│───────────▶                     │
         │                     │         │           │  ┌─────────────┐    │
         │                     │         │           │  │ Response    │    │
         │                     │         │           │  │ VALID +     │◀───│
         │                     │         │           │  │ Data        │    │
         │                     │         │           │  │ Penumpang   │    │
         │                     │         │           │  └──────┬──────┘    │
         │                     │         │           │         │           │
         │                     │         │           │         ▼           │
         │                     │         │           │  ┌─────────────┐    │
         │  BOARDING ◀─────────│─────────│───────────│  │ Izinkan     │    │
         │  ALLOWED            │         │           │  │ Penumpang   │    │
         │                     │         │           │  │ Masuk       │    │
         │                     │         │           │  └──────┬──────┘    │
         │                     │         │           │         │           │
         │                     │         │           │         ▼           │
         │                     │         │           │  ┌─────────────┐    │
         │                     │         │           │  │ Laporan     │────▶
         │                     │         │           │  │ Boarding    │    │  ┌─────────────┐
         │                     │         │           │  │ Hari Ini    │    │  │ Dashboard   │
         │                     │         │           │  └─────────────┘    │  │ Statistik   │
         │                     │         │           │                     │  │ Penjualan   │
         │                     │         │           │                     │  └─────────────┘
         │                     │         │           │                     │
         ▼                     ▼         ▼           ▼                     ▼
```

## 5.3 Daftar Dokumen dalam Sistem

| No | Nama Dokumen | Format | Pembuat | Penerima | Keterangan |
|----|--------------|--------|---------|----------|------------|
| 1 | Form Pencarian Jadwal | Web Form | User | Sistem | Input rute & tanggal |
| 2 | Data Jadwal Tersedia | HTML | Sistem | User | Hasil query database |
| 3 | Form Data Penumpang | Web Form | User | Sistem | Data setiap penumpang |
| 4 | Ringkasan Pesanan | HTML | Sistem | User | Review sebelum bayar |
| 5 | Payment Request | JSON | Sistem | Midtrans | Request Snap Token |
| 6 | Payment Popup | iFrame | Midtrans | User | Interface pembayaran |
| 7 | Payment Callback | JSON | Midtrans | Sistem | Status pembayaran |
| 8 | **E-Ticket** | PDF | Sistem | User | Tiket digital + QR |
| 9 | QR Code | Image | Sistem | User | Kode validasi unik |
| 10 | Boarding Request | JSON | Staff | Sistem | Request validasi |
| 11 | Boarding Response | JSON | Sistem | Staff | Hasil validasi |
| 12 | Laporan Boarding | Report | Sistem | Admin | Statistik harian |
| 13 | Laporan Penjualan | Report | Sistem | Admin | Dashboard revenue |

---

# BAGIAN 6: KESIMPULAN

## 6.1 Ringkasan

Dokumentasi ini menjelaskan:

1. **Proses Pengumpulan Data** - Melalui observasi, wawancara, studi literatur, dan analisis dokumen untuk mengidentifikasi kebutuhan sistem pemesanan tiket ferry online.

2. **Rencana Implementasi** - Menggunakan arsitektur modern dengan Laravel, Livewire, dan Filament, diimplementasikan dalam 9 sprint selama 4,5 bulan.

3. **System Flow Diagram** - Menggambarkan alur proses pemesanan, boarding, dan administrasi dalam sistem.

4. **Document Flow Diagram** - Menggambarkan alur dokumen dari pengguna melalui sistem hingga ke staff dan admin.

## 6.2 Link Demo

| Item | URL |
|------|-----|
| Production | https://app-tickets-244be60c2a8e.herokuapp.com |
| Admin Panel | https://app-tickets-244be60c2a8e.herokuapp.com/admin |

## 6.3 Kredensial Testing

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@semabu.com | password |
| Staff | staff@semabu.com | password |
| User | user@example.com | password |

---

*Dokumen ini disusun untuk memenuhi tugas UAS mata kuliah Teknologi Informasi Pariwisata (TIP).*

**Tanggal:** 20 Januari 2026
