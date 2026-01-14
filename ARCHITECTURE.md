# 🚢 Ferry Ticket Booking System - Architecture Documentation

## Daftar Isi

-   [Overview](#overview)
-   [Tech Stack](#tech-stack)
-   [Backend Architecture](#backend-architecture)
-   [Frontend Architecture](#frontend-architecture)
-   [Database Schema](#database-schema)
-   [API Documentation](#api-documentation)
-   [Payment Integration](#payment-integration)
-   [Testing](#testing)
-   [Security](#security)
-   [Deployment](#deployment)

---

## Overview

Sistem pemesanan tiket ferry online untuk rute Bali - Nusa Penida, Lembongan, dan Gili Islands. Aplikasi ini mendukung:

-   ✅ Pencarian jadwal kapal
-   ✅ Pemesanan tiket online
-   ✅ Pembayaran via Midtrans (VA, E-Wallet, Credit Card)
-   ✅ E-Ticket dengan QR Code
-   ✅ Boarding system dengan QR Scanner
-   ✅ Admin Panel dengan Filament
-   ✅ Gallery destinasi
-   ✅ Contact form management
-   ✅ Auto-expiration untuk order yang belum dibayar

---

## Tech Stack

### Backend

| Technology | Version | Purpose              |
| ---------- | ------- | -------------------- |
| PHP        | ^8.4    | Server-side language |
| Laravel    | 12.x    | PHP Framework        |
| Livewire   | 3.7     | Reactive components  |
| Filament   | 4.4     | Admin panel          |
| MySQL      | 8.x     | Database             |

### Frontend

| Technology   | Version | Purpose                             |
| ------------ | ------- | ----------------------------------- |
| Tailwind CSS | 4.0     | Utility-first CSS                   |
| Flowbite     | 4.0     | UI Components                       |
| Alpine.js    | 3.x     | JavaScript framework (via Livewire) |
| Vite         | 7.x     | Build tool                          |

### External Services

| Service                 | Purpose                         |
| ----------------------- | ------------------------------- |
| Midtrans                | Payment Gateway                 |
| SimpleSoftwareIO/QrCode | QR Code Generation (SVG)        |
| chillerlan/php-qrcode   | QR Code Generation (PNG/Base64) |
| DomPDF                  | PDF Generation                  |

---

## Backend Architecture

### Directory Structure

```
app/
├── Console/Commands/           # Artisan commands
│   ├── ExpireUnpaidOrders.php  # Auto-expire unpaid orders
│   └── GenerateTickets.php     # Ticket generation command
├── Filament/Admin/Resources/   # Filament admin resources
│   ├── Destinations/
│   ├── GalleryImages/
│   ├── Messages/
│   ├── Orders/
│   ├── Routes/
│   ├── Schedules/
│   ├── Ships/
│   ├── Tickets/
│   └── Users/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php         # User authentication
│   │   ├── BoardingController.php     # QR scanning, boarding system
│   │   ├── ContactController.php      # Contact form handling
│   │   ├── DestinationController.php  # Destination listings
│   │   ├── GalleryController.php      # Photo gallery
│   │   ├── PageController.php         # Static pages
│   │   ├── PaymentController.php      # Payment flow, Midtrans
│   │   ├── ScheduleController.php     # Schedule search API
│   │   ├── StaffAuthController.php    # Staff authentication
│   │   ├── TicketController.php       # Ticket display, validation
│   │   └── TicketPdfController.php    # PDF generation & download
│   └── Middleware/
│       └── EnsureUserIsStaff.php
├── Livewire/                    # Livewire components
│   ├── BookingForm.php          # Multi-step booking
│   ├── DestinationSection.php   # Destination display
│   ├── ScheduleSection.php      # Schedule display
│   ├── SearchBookingForm.php    # Schedule search
│   ├── SearchResults.php        # Search results display
│   └── TicketPage.php           # Ticket display (SPA-like)
├── Models/
│   ├── Destination.php
│   ├── GalleryImage.php         # Photo gallery images
│   ├── Message.php              # Contact form messages
│   ├── Order.php
│   ├── Passenger.php
│   ├── Route.php
│   ├── Schedule.php
│   ├── Ship.php
│   ├── Ticket.php
│   └── User.php
├── Observers/
│   ├── DestinationObserver.php  # Cache invalidation
│   └── ScheduleObserver.php     # Cache invalidation
├── Providers/
│   └── Filament/
├── Repositories/                 # Future repository pattern
└── Services/                     # Business logic services
    ├── BoardingStatsService.php      # Boarding statistics
    ├── CacheService.php              # Application caching
    ├── MidtransService.php           # Payment integration
    ├── QrCodeParserService.php       # QR code parsing
    ├── QrCodeService.php             # QR code generation
    ├── TicketPdfService.php          # PDF generation
    ├── TicketService.php             # Ticket management
    └── TicketValidationService.php   # Ticket validation
```

### Controllers

| Controller              | Responsibility                              |
| ----------------------- | ------------------------------------------- |
| `AuthController`        | User login, register, logout                |
| `BoardingController`    | QR scanning, boarding system dashboard      |
| `ContactController`     | Contact form submission handling            |
| `DestinationController` | Destination listings (islands, harbors)     |
| `GalleryController`     | Photo gallery for destinations              |
| `PageController`        | Static pages (home, about, contact, ticket) |
| `PaymentController`     | Payment flow, Midtrans callbacks            |
| `ScheduleController`    | Schedule search API                         |
| `StaffAuthController`   | Staff authentication                        |
| `TicketController`      | Ticket display, validation                  |
| `TicketPdfController`   | PDF generation & download                   |

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
    public function generateQrCode(Ticket $ticket): string;
}
```

#### TicketValidationService

```php
class TicketValidationService
{
    public function validateTicket(string $qrCode): array;
    public function useTicket(Ticket $ticket, ?string $usedBy): array;
    public function getInvalidReason(Ticket $ticket): string;
}
```

#### QrCodeService

```php
class QrCodeService
{
    public function getQrContent(Ticket $ticket): string;
    public function generateImage(Ticket $ticket): ?string;
    public function generateSvg(Ticket $ticket): string;
    public function generateBase64Png(Ticket $ticket): string;
}
```

#### TicketPdfService

```php
class TicketPdfService
{
    public function generatePdf(Order $order): PDF;
    public function generateAndSavePdf(Order $order): string;
    public function downloadPdf(Order $order): Response;
    public function streamPdf(Order $order): Response;
}
```

#### BoardingStatsService

```php
class BoardingStatsService
{
    public function getTodaySchedulesWithStats(): Collection;
    public function getTodayStats(): array;
    public function getRealtimeStats(?int $scheduleId): array;
    public function getStatusLabel(string $status): string;
}
```

#### CacheService

```php
class CacheService
{
    public static function getActiveDestinations();
    public static function getIslands();
    public static function getHarbors();
    public static function getActiveRoutes();
    public static function getActiveShips();
    public static function getSchedules(int $routeId, string $date);
    public static function clearAll();
}
```

#### QrCodeParserService

```php
class QrCodeParserService
{
    public function extractQrCode(string $data): ?string;
}
```

### Livewire Components

| Component            | Purpose                | Features                                     |
| -------------------- | ---------------------- | -------------------------------------------- |
| `SearchBookingForm`  | Schedule search        | Reactive search, round-trip support          |
| `BookingForm`        | Multi-step booking     | Contact info, passenger data, order creation |
| `SearchResults`      | Search results display | Paginated results with filters               |
| `ScheduleSection`    | Schedule display       | Interactive schedule cards                   |
| `DestinationSection` | Destination display    | Island/harbor listings                       |
| `TicketPage`         | Ticket display         | SPA-like, no page reload, PDF download       |

### Console Commands

| Command              | Schedule        | Purpose                                    |
| -------------------- | --------------- | ------------------------------------------ |
| `ExpireUnpaidOrders` | Every 5 minutes | Auto-expire unpaid orders after 30 minutes |
| `GenerateTickets`    | On-demand       | Generate tickets for paid orders           |

### Observers

| Observer              | Model       | Purpose                    |
| --------------------- | ----------- | -------------------------- |
| `DestinationObserver` | Destination | Cache invalidation on CRUD |
| `ScheduleObserver`    | Schedule    | Cache invalidation on CRUD |

---

## Frontend Architecture

### Blade Components

#### UI Components (`resources/views/components/ui/`)

```
ui/
├── alert.blade.php         # Flowbite-style alerts
├── badge.blade.php         # Status badges with colors
├── button.blade.php        # Buttons with variants
├── card.blade.php          # Card container
├── close-button.blade.php  # Close/dismiss button
└── spinner.blade.php       # Loading spinner
```

#### Ticket Components (`resources/views/components/ticket/`)

```
ticket/
├── card.blade.php      # Ticket card with QR code
├── trip-info.blade.php # Trip information display
└── info-item.blade.php # Reusable info item
```

#### Page Components (`resources/views/components/`)

```
components/
├── alert-modal.blade.php       # Modal dialogs
├── cta-section.blade.php       # Call-to-action section
├── destination-card.blade.php  # Destination card
├── faq-section.blade.php       # FAQ accordion (Alpine.js)
├── feature-section.blade.php   # Feature highlights
├── footer.blade.php            # Site footer
├── header-section.blade.php    # Page headers
├── hero-section.blade.php      # Homepage hero
├── navbar.blade.php            # Navigation bar
└── ticket-step-section.blade.php # Booking steps guide
```

### View Components (PHP Classes)

```
app/View/Components/
├── DestinationCard.php
├── Faq-Section.php
├── cta-section.php
├── feature-section.php
├── footer.php
├── header-section.php
├── hero-section.php
├── layouts.app.php
├── navbar.php
└── ticketStep-section.php
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
└── booking-confirmation.blade.php
```

### Additional Views

```
views/
├── auth/                # Login/register pages
├── boarding/            # Boarding system views
├── destinations/        # Destination pages
├── errors/              # Error pages
├── livewire/            # Livewire component views
├── pdf/                 # PDF templates
├── staff/               # Staff login
└── tickets/             # Ticket display views
```

---

## Database Schema

### Entity Relationship Diagram

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

┌─────────────┐
│   Message   │  (Contact form submissions)
└─────────────┘
```

### Tables

| Table            | Description        | Key Fields                                                    |
| ---------------- | ------------------ | ------------------------------------------------------------- |
| `users`          | User accounts      | name, email, role (user/staff/admin)                          |
| `destinations`   | Harbors & islands  | name, slug, type, coordinates, is_active                      |
| `gallery_images` | Destination photos | destination_id, image_path, caption                           |
| `routes`         | Route definitions  | origin_id, destination_id, duration, is_active                |
| `ships`          | Ship information   | name, capacity, facilities (JSON), is_active                  |
| `schedules`      | Schedule times     | route_id, ship_id, departure_time, price, available_seats     |
| `orders`         | Booking orders     | order_number, schedule_id, status, payment_status, expires_at |
| `passengers`     | Passenger data     | order_id, name, id_type, id_number                            |
| `tickets`        | E-Tickets          | order_id, passenger_id, ticket_number, qr_code, status        |
| `messages`       | Contact form       | name, email, subject, message, is_read                        |

### Order Status Flow

```
pending → confirmed → completed
    ↓
cancelled/expired
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

| Parameter      | Type    | Required | Description                       |
| -------------- | ------- | -------- | --------------------------------- |
| origin_id      | integer | Yes      | Origin destination ID             |
| destination_id | integer | Yes      | Destination ID                    |
| date           | date    | Yes      | Travel date (YYYY-MM-DD)          |
| passengers     | integer | No       | Number of passengers (default: 1) |

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "route": {
                "id": 1,
                "code": "SAN-NP",
                "origin": "Sanur",
                "destination": "Nusa Penida"
            },
            "ship": {
                "name": "Express Bahari 1",
                "facilities": ["AC", "Toilet"]
            },
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

| Parameter | Type   | Description               |
| --------- | ------ | ------------------------- |
| used_by   | string | Name of staff who scanned |

#### Process Validation (Combined)

```http
POST /api/ticket/process-validation
```

| Parameter | Type   | Description         |
| --------- | ------ | ------------------- |
| qr_code   | string | QR code content     |
| action    | string | `validate` or `use` |

#### Contact Form

```http
POST /contact
```

| Parameter | Type   | Required | Description     |
| --------- | ------ | -------- | --------------- |
| name      | string | Yes      | Sender name     |
| email     | email  | Yes      | Sender email    |
| subject   | string | Yes      | Message subject |
| message   | string | Yes      | Message content |

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

#### Boarding Stats

```http
GET /boarding/stats
```

Returns real-time boarding statistics (authenticated).

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
2. System creates Order (status: pending, payment: unpaid, expires_at: +30min)
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

### Auto-Expiration

-   Orders expire after 30 minutes if unpaid
-   `ExpireUnpaidOrders` command runs every 5 minutes
-   Expired orders cannot be paid

### Supported Payment Methods

-   💳 Credit/Debit Card (3DS)
-   🏦 Bank Transfer (BCA, BNI, BRI, Mandiri, Permata)
-   📱 E-Wallet (GoPay, ShopeePay, DANA, OVO)
-   🏪 Retail (Alfamart, Indomaret)

---

## Testing

### Test Structure

```
tests/
├── Pest.php                          # Pest configuration
├── TestCase.php                      # Base test class
├── Feature/
│   ├── AuthenticationTest.php        # Auth flow tests
│   ├── AutoBoardingTest.php          # Boarding system tests
│   ├── BookingFlowTest.php           # Booking flow tests
│   ├── GalleryArchitectureTest.php   # Gallery tests
│   ├── GalleryImageResourceTest.php  # Filament resource tests
│   ├── GalleryRouteTest.php          # Gallery route tests
│   ├── GallerySimpleTest.php         # Simple gallery tests
│   ├── GalleryTest.php               # Gallery integration tests
│   ├── ImageCompressionServiceTest.php
│   ├── QrTicketTest.php              # QR & ticket tests
│   ├── ScheduleSearchTest.php        # Schedule search tests
│   └── UserManagementTest.php        # User management tests
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

| Test Suite         | Description                        |
| ------------------ | ---------------------------------- |
| AuthenticationTest | User login, register, logout flows |
| AutoBoardingTest   | Boarding system, QR scanning       |
| BookingFlowTest    | Complete booking process           |
| GalleryTest        | Photo gallery functionality        |
| QrTicketTest       | Ticket validation, QR codes        |
| ScheduleSearchTest | Schedule search API                |
| UserManagementTest | User CRUD operations               |

### Key Test Cases

#### BookingFlowTest

-   ✅ Can create order with passengers
-   ✅ Can generate tickets after payment
-   ✅ Ticket has correct passenger information
-   ✅ Order total is calculated correctly
-   ✅ Schedule available seats decrease after booking
-   ✅ Booking page redirects without session data
-   ✅ Can view ticket with order number

#### QrTicketTest

-   ✅ Ticket QR code contains correct data
-   ✅ Ticket can be verified by QR data
-   ✅ Invalid QR code returns error
-   ✅ Ticket can be checked in (boarded)
-   ✅ Used ticket cannot be checked in again
-   ✅ Ticket for wrong date cannot be used

#### ScheduleSearchTest

-   ✅ Can search schedules for valid date
-   ✅ Returns empty when no schedules match
-   ✅ Filters by available seats
-   ✅ Validates required parameters

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

-   All forms protected by CSRF tokens
-   Exception for Midtrans webhook (verified by signature)

### Rate Limiting

-   Login: 5 attempts per minute
-   Register: 3 attempts per hour
-   Payment token: 10 requests per minute
-   Status check: 30 requests per minute

### Authentication

-   User authentication for customer features
-   Staff authentication for boarding system
-   Role-based access (user, staff, admin)

### Input Validation

```php
$validated = $request->validate([
    'origin_id' => 'required|exists:destinations,id',
    'destination_id' => 'required|different:origin_id',
    'date' => 'required|date|after_or_equal:today',
]);
```

### Payment Security

-   Midtrans server-to-server verification
-   Payment status double-checked via API
-   Order expiration prevents abandoned orders

---

## Deployment

### Requirements

-   PHP 8.2+
-   MySQL 8.0+
-   Composer 2.x
-   Node.js 18+
-   SSL Certificate (required for Midtrans)

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
// routes/console.php
Schedule::command('orders:expire-unpaid')->everyFiveMinutes();
```

---

## Admin Panel

### Filament Resources

| Resource          | Description                   |
| ----------------- | ----------------------------- |
| **Destinations**  | Manage harbors & islands      |
| **GalleryImages** | Manage destination photos     |
| **Messages**      | View contact form submissions |
| **Orders**        | Manage bookings               |
| **Routes**        | Manage ferry routes           |
| **Schedules**     | Manage schedules              |
| **Ships**         | Manage ships                  |
| **Tickets**       | View/manage tickets           |
| **Users**         | User management               |

### Access

```
URL: /admin
Default Admin: Create via tinker or seeder
```

---

## Caching Strategy

### Cache TTL Configuration

| TTL    | Duration   | Use Case                    |
| ------ | ---------- | --------------------------- |
| SHORT  | 5 minutes  | Schedule searches           |
| MEDIUM | 30 minutes | Destinations, routes, ships |
| LONG   | 1 hour     | Static data                 |
| DAY    | 24 hours   | Rarely changed data         |

### Cached Data

-   Active destinations (islands, harbors)
-   Active routes
-   Active ships
-   Schedule searches by date and route
-   Destination by slug

### Cache Invalidation

-   Automatic via Observers on model changes
-   Manual via `CacheService::clearAll()`

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

_Documentation last updated: January 14, 2026_
