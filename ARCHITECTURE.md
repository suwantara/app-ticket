# 🚢 Ferry Ticket Booking System - Architecture Documentation

## Daftar Isi
- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Backend Architecture](#backend-architecture)
- [Frontend Architecture](#frontend-architecture)
- [Database Schema](#database-schema)
- [API Documentation](#api-documentation)
- [Payment Integration](#payment-integration)
- [Testing](#testing)
- [Security](#security)
- [Deployment](#deployment)

---

## Overview

Sistem pemesanan tiket ferry online untuk rute Bali - Nusa Penida, Lembongan, dan Gili Islands. Aplikasi ini mendukung:
- ✅ Pencarian jadwal kapal
- ✅ Pemesanan tiket online
- ✅ Pembayaran via Midtrans (VA, E-Wallet, Credit Card)
- ✅ E-Ticket dengan QR Code
- ✅ Boarding system dengan QR Scanner
- ✅ Admin Panel dengan Filament

---

## Tech Stack

### Backend
| Technology | Version | Purpose |
|------------|---------|---------|
| PHP | ^8.2 | Server-side language |
| Laravel | 12.x | PHP Framework |
| Livewire | 3.7 | Reactive components |
| Filament | 4.4 | Admin panel |
| MySQL | 8.x | Database |

### Frontend
| Technology | Version | Purpose |
|------------|---------|---------|
| Tailwind CSS | 4.0 | Utility-first CSS |
| Flowbite | 4.0 | UI Components |
| Alpine.js | 3.x | JavaScript framework (via Livewire) |
| Vite | 7.x | Build tool |

### External Services
| Service | Purpose |
|---------|---------|
| Midtrans | Payment Gateway |
| SimpleSoftwareIO/QrCode | QR Code Generation |
| DomPDF | PDF Generation |

---

## Backend Architecture

### Directory Structure
```
app/
├── Console/Commands/         # Artisan commands
├── Filament/Admin/          # Filament admin resources
├── Http/
│   ├── Controllers/         # HTTP Controllers
│   │   ├── BoardingController.php
│   │   ├── DestinationController.php
│   │   ├── PageController.php
│   │   ├── PaymentController.php
│   │   ├── ScheduleController.php
│   │   ├── StaffAuthController.php
│   │   ├── TicketController.php
│   │   └── TicketPdfController.php
│   └── Middleware/
│       └── EnsureUserIsStaff.php
├── Livewire/                # Livewire components
│   ├── BookingForm.php      # Multi-step booking
│   ├── SearchBookingForm.php # Schedule search
│   └── TicketPage.php       # Ticket display (SPA-like)
├── Models/                  # Eloquent models
│   ├── Destination.php
│   ├── Order.php
│   ├── Page.php
│   ├── Passenger.php
│   ├── Route.php
│   ├── Schedule.php
│   ├── Ship.php
│   ├── Ticket.php
│   └── User.php
├── Providers/
│   └── Filament/
└── Services/                # Business logic services
    ├── MidtransService.php  # Payment integration
    └── TicketService.php    # Ticket management
```

### Controllers

| Controller | Responsibility |
|------------|---------------|
| `PageController` | Static pages, CMS content |
| `PaymentController` | Payment flow, Midtrans callbacks |
| `TicketController` | Ticket display, validation |
| `TicketPdfController` | PDF generation & download |
| `ScheduleController` | Schedule search API |
| `DestinationController` | Destination listings |
| `BoardingController` | QR scanning, boarding system |
| `StaffAuthController` | Staff authentication |

### Services

#### MidtransService
```php
class MidtransService
{
    public function createSnapToken(Order $order): array;
    public function getTransactionStatus(string $orderId): array;
    public function handleNotification(array $notification): array;
}
```

#### TicketService
```php
class TicketService
{
    public function generateTicketsForOrder(Order $order): array;
    public function generateQrCodeImage(Ticket $ticket): ?string;
    public function validateTicket(string $qrCode): array;
    public function useTicket(Ticket $ticket, ?string $usedBy): array;
    public function generatePdf(Order $order): PDF;
}
```

### Livewire Components

| Component | Purpose | Features |
|-----------|---------|----------|
| `SearchBookingForm` | Schedule search | Reactive search, round-trip support |
| `BookingForm` | Multi-step booking | Contact info, passenger data, order creation |
| `TicketPage` | Ticket display | SPA-like, no page reload, PDF download |

---

## Frontend Architecture

### Blade Components

#### UI Components (`resources/views/components/ui/`)
```
ui/
├── alert.blade.php    # Flowbite-style alerts (info, success, warning, danger)
├── badge.blade.php    # Status badges with colors
├── button.blade.php   # Buttons with variants (primary, secondary, outline)
├── card.blade.php     # Card container with header slot
└── spinner.blade.php  # Loading spinner
```

#### Ticket Components (`resources/views/components/ticket/`)
```
ticket/
├── card.blade.php      # Ticket card with QR code
├── trip-info.blade.php # Trip information display
└── info-item.blade.php # Reusable info item
```

### Layouts
```
components/layouts/
└── app.blade.php       # Main application layout
```

### Page Templates
```
pages/
├── home.blade.php
├── ticket.blade.php
├── about.blade.php
├── contact.blade.php
├── payment.blade.php
├── booking-confirmation.blade.php
└── templates/
    └── default.blade.php   # CMS template
```

---

## Database Schema

### Entity Relationship Diagram

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ Destination │◄────│    Route    │────►│ Destination │
│  (origin)   │     │             │     │(destination)│
└─────────────┘     └──────┬──────┘     └─────────────┘
                           │
                           ▼
                    ┌─────────────┐     ┌─────────────┐
                    │  Schedule   │────►│    Ship     │
                    └──────┬──────┘     └─────────────┘
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

### Tables

| Table | Description | Key Fields |
|-------|-------------|------------|
| `users` | User accounts | name, email, role (user/staff/admin) |
| `destinations` | Harbors & islands | name, slug, type, coordinates |
| `routes` | Route definitions | origin_id, destination_id, duration |
| `ships` | Ship information | name, capacity, facilities (JSON) |
| `schedules` | Schedule times | route_id, ship_id, departure_time, price, days_of_week |
| `orders` | Booking orders | order_number, schedule_id, status, payment_status |
| `passengers` | Passenger data | order_id, name, id_type, id_number |
| `tickets` | E-Tickets | order_id, passenger_id, ticket_number, qr_code, status |
| `pages` | CMS pages | title, slug, content, sections (JSON) |

### Order Status Flow
```
pending → confirmed → completed
    ↓
cancelled
```

### Payment Status Flow
```
unpaid → pending → paid
    ↓         ↓
 expired   failed
```

### Ticket Status Flow
```
active → used
   ↓
cancelled/expired
```

---

## API Documentation

### Public Endpoints

#### Schedule Search
```http
GET /schedules/search
```
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| origin_id | integer | Yes | Origin destination ID |
| destination_id | integer | Yes | Destination ID |
| date | date | Yes | Travel date (YYYY-MM-DD) |
| passengers | integer | No | Number of passengers (default: 1) |

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "route": { "id": 1, "code": "SAN-NP", "origin": "Sanur", "destination": "Nusa Penida" },
      "ship": { "name": "Express Bahari 1", "facilities": ["AC", "Toilet"] },
      "departure_time": "07:30",
      "arrival_time": "08:15",
      "price": 150000,
      "price_formatted": "Rp 150.000",
      "available_seats": 80
    }
  ],
  "meta": { "total_schedules": 5 }
}
```

#### Ticket Validation
```http
GET /api/ticket/validate/{qrCode}
```
**Response:**
```json
{
  "valid": true,
  "message": "Tiket valid dan dapat digunakan",
  "ticket": {
    "ticket_number": "TKT-20260101-ABC12",
    "status": "active",
    "passenger": { "name": "John Doe" },
    "order": { "travel_date": "2026-01-04" }
  }
}
```

#### Mark Ticket as Used
```http
POST /api/ticket/use/{ticket}
```
| Parameter | Type | Description |
|-----------|------|-------------|
| used_by | string | Name of staff who scanned |

#### Process Validation (Combined)
```http
POST /api/ticket/process-validation
```
| Parameter | Type | Description |
|-----------|------|-------------|
| qr_code | string | QR code content |
| action | string | `validate` or `use` |

### Internal Endpoints

#### Payment Callback (Midtrans)
```http
POST /payment/notification
```
Handles Midtrans server-to-server notification.

#### Payment Status Check
```http
GET /payment/{order}/status
```
Returns current payment status with Midtrans verification.

---

## Payment Integration

### Midtrans Configuration

```php
// config/midtrans.php
return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,
];
```

### Payment Flow

```
1. User completes booking
        ↓
2. System creates Order (status: pending, payment: unpaid)
        ↓
3. Generate Snap Token via MidtransService
        ↓
4. Display Snap payment popup
        ↓
5a. User completes payment → Redirect to finish URL
5b. Midtrans sends notification webhook
        ↓
6. Verify payment status via API
        ↓
7. Update order status (confirmed, paid)
        ↓
8. Generate tickets automatically
        ↓
9. Redirect to ticket page
```

### Supported Payment Methods
- 💳 Credit/Debit Card (3DS)
- 🏦 Bank Transfer (BCA, BNI, BRI, Mandiri, Permata)
- 📱 E-Wallet (GoPay, ShopeePay, DANA, OVO)
- 🏪 Retail (Alfamart, Indomaret)

---

## Testing

### Test Structure
```
tests/
├── Pest.php           # Pest configuration
├── TestCase.php       # Base test class
├── Feature/
│   ├── BookingFlowTest.php     # Booking flow tests
│   ├── QrTicketTest.php        # QR & ticket tests
│   ├── ScheduleSearchTest.php  # Schedule search tests
│   └── ExampleTest.php
└── Unit/
    └── ExampleTest.php
```

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test --filter=BookingFlowTest

# Run with coverage
php artisan test --coverage
```

### Test Coverage

| Test Suite | Tests | Assertions |
|------------|-------|------------|
| BookingFlowTest | 7 | 20+ |
| QrTicketTest | 8 | 25+ |
| ScheduleSearchTest | 6 | 15+ |
| **Total** | **23** | **64** |

### Key Test Cases

#### BookingFlowTest
- ✅ Can create order with passengers
- ✅ Can generate tickets after payment
- ✅ Ticket has correct passenger information
- ✅ Order total is calculated correctly
- ✅ Schedule available seats decrease after booking
- ✅ Booking page redirects without session data
- ✅ Can view ticket with order number

#### QrTicketTest
- ✅ Ticket QR code contains correct data
- ✅ Ticket can be verified by QR data
- ✅ Invalid QR code returns error
- ✅ Ticket can be checked in (boarded)
- ✅ Used ticket cannot be checked in again
- ✅ Ticket for wrong date cannot be used

#### ScheduleSearchTest
- ✅ Can search schedules for valid date
- ✅ Returns empty when no schedules match
- ✅ Filters by available seats
- ✅ Validates required parameters

---

## Security

### IDOR Prevention
```php
// Order model uses order_number instead of ID
public function getRouteKeyName(): string
{
    return 'order_number';
}
```

### CSRF Protection
- All forms protected by CSRF tokens
- Exception for Midtrans webhook (verified by signature)

### Authentication
- Staff authentication for boarding system
- Role-based access (user, staff, admin)

### Input Validation
```php
$validated = $request->validate([
    'origin_id' => 'required|exists:destinations,id',
    'destination_id' => 'required|different:origin_id',
    'date' => 'required|date|after_or_equal:today',
]);
```

### Payment Security
- Midtrans server-to-server verification
- Payment status double-checked via API
- Secure token generation for PDF downloads

---

## Deployment

### Requirements
- PHP 8.2+
- MySQL 8.0+
- Composer 2.x
- Node.js 18+
- SSL Certificate (required for Midtrans)

### Environment Variables
```env
APP_NAME="Ferry Ticket"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=ferry_ticket
DB_USERNAME=root
DB_PASSWORD=

MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=true
```

### Deployment Commands
```bash
# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan icons:cache

# Run migrations
php artisan migrate --force

# Set permissions
chmod -R 775 storage bootstrap/cache
```

### Scheduled Tasks
```php
// app/Console/Kernel.php
$schedule->command('tickets:expire')->daily();
$schedule->command('orders:cancel-expired')->hourly();
```

---

## Admin Panel

### Filament Resources
- **Orders** - Manage bookings
- **Tickets** - View/manage tickets
- **Schedules** - Manage schedules
- **Ships** - Manage ships
- **Routes** - Manage routes
- **Destinations** - Manage harbors/islands
- **Pages** - CMS page management
- **Users** - User management

### Access
```
URL: /admin
Default Admin: Create via tinker or seeder
```

---

## Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

---

## License

This project is proprietary software. All rights reserved.

---

*Documentation last updated: January 2, 2026*
