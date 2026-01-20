# 🎫 Ferry Ticket Booking System - MVP Documentation

## Overview

Sistem pemesanan tiket kapal feri yang lengkap dengan fitur booking online, payment gateway, e-ticket, QR code boarding, dan admin panel.

## Tech Stack

- **Framework:** Laravel 12.44.0
- **PHP:** 8.4.7
- **Admin Panel:** Filament 4.4.0
- **Frontend:** Livewire 3.x, TailwindCSS
- **Payment:** Midtrans
- **PDF:** DomPDF
- **QR Code:** SimpleSoftwareIO/QrCode
- **Database:** MySQL

## Features

### 🎯 Core Features (MVP Complete)

| Feature | Status | Description |
|---------|--------|-------------|
| Destination Management | ✅ | Islands & harbors |
| Route Management | ✅ | Origin-destination pairs |
| Ship Management | ✅ | Capacity, facilities, operator |
| Schedule Management | ✅ | Daily schedules with pricing |
| Booking Flow | ✅ | Multi-passenger booking |
| Payment Gateway | ✅ | Midtrans integration |
| E-Ticket Generation | ✅ | Auto-generate after payment |
| QR Code | ✅ | Unique per ticket |
| PDF Download | ✅ | Multi-page PDF per order |
| QR Scanner/Boarding | ✅ | Staff boarding system |
| Admin Panel | ✅ | Full CRUD operations |

### 📦 Application Structure

```
app/
├── Filament/Admin/           # Admin panel resources
│   ├── Resources/
│   │   ├── Destinations/
│   │   ├── Orders/
│   │   ├── Routes/
│   │   ├── Schedules/
│   │   ├── Ships/
│   │   ├── Tickets/
│   │   └── Users/
│   └── Pages/
│       └── Dashboard.php
├── Http/Controllers/
│   ├── BoardingController.php    # Staff boarding system
│   ├── PageController.php        # Static pages
│   ├── PaymentController.php     # Midtrans integration
│   ├── ScheduleController.php    # Schedule search
│   ├── TicketController.php      # Ticket display
│   └── TicketPdfController.php   # PDF generation
├── Livewire/
│   ├── BookingForm.php           # Booking process
│   └── SearchBookingForm.php     # Schedule search
├── Models/
│   ├── Destination.php
│   ├── Order.php
│   ├── Page.php
│   ├── Passenger.php
│   ├── Route.php
│   ├── Schedule.php
│   ├── Ship.php
│   ├── Ticket.php
│   └── User.php
└── Services/
    ├── MidtransService.php       # Payment service
    └── TicketService.php         # Ticket generation
```

### 🔐 User Roles

| Role | Access |
|------|--------|
| Admin | Full admin panel access |
| Staff | Boarding system + limited admin |
| Guest | Booking & ticket view |

## Routes

### Public Routes
```
GET  /                          # Homepage
GET  /booking                   # Booking form
GET  /booking/confirmation/{order}  # Booking confirmation
GET  /schedules/search          # Search schedules API
GET  /ticket/order/{order}      # View tickets
GET  /ticket/pdf/{order}/download   # Download PDF
GET  /ticket/pdf/{order}/view       # View PDF in browser
```

### Payment Routes
```
GET  /payment/{order}           # Payment page
POST /payment/{order}/token     # Create payment token
GET  /payment/{order}/finish    # Payment success
POST /payment/notification      # Midtrans webhook
```

### Staff/Boarding Routes
```
GET  /staff/login               # Staff login
GET  /boarding/                 # Boarding dashboard
GET  /boarding/scanner          # QR scanner
POST /boarding/validate         # Validate QR
POST /boarding/board            # Board passenger
```

### Admin Routes
```
GET  /admin                     # Admin dashboard
GET  /admin/destinations/*      # Destination CRUD
GET  /admin/routes/*            # Route CRUD
GET  /admin/ships/*             # Ship CRUD
GET  /admin/schedules/*         # Schedule CRUD
GET  /admin/orders/*            # Order management
GET  /admin/tickets/*           # Ticket management
GET  /admin/users/*             # User management
```

## Database Schema

### Core Tables
- `destinations` - Islands & harbors
- `routes` - Origin-destination pairs
- `ships` - Vessel information
- `schedules` - Daily schedules
- `orders` - Booking orders
- `passengers` - Passenger information
- `tickets` - Generated tickets
- `users` - Admin/Staff accounts
- `pages` - CMS pages

## Installation

```bash
# Clone repository
git clone <repository-url>
cd app-ticket

# Install dependencies
composer install
npm install

# Copy environment
cp .env.example .env

# Generate key
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ferry_ticket
DB_USERNAME=root
DB_PASSWORD=

# Configure Midtrans in .env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true

# Run migrations & seeders
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start server
php artisan serve
```

## Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test --filter=BookingFlowTest

# Run with coverage
php artisan test --coverage
```

### Test Coverage
- Unit tests: 1 test
- Feature tests: 22 tests
- **Total: 23 tests, 64 assertions**

## API Endpoints

### Schedule Search
```
GET /schedules/search
Parameters:
- origin_id: required
- destination_id: required
- date: required (Y-m-d)
- passengers: optional (default: 1)

Response:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "departure_time": "08:00",
      "arrival_time": "08:45",
      "price": 150000,
      "available_seats": 80,
      "ship": {...},
      "route": {...}
    }
  ]
}
```

### Ticket Validation
```
GET /api/ticket/validate/{qrCode}

Response:
{
  "valid": true,
  "message": "Tiket valid dan dapat digunakan",
  "ticket": {...}
}
```

## Deployment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set Midtrans production keys
- [ ] Configure mail settings
- [ ] Set up SSL certificate
- [ ] Configure queue worker
- [ ] Set up scheduled tasks
- [ ] Configure file storage
- [ ] Set up backup system

## MVP Status

### Day-by-Day Progress

| Day | Features | Status |
|-----|----------|--------|
| 1 | Project setup, Database schema | ✅ |
| 2 | Filament admin panel | ✅ |
| 3 | Frontend & Schedule search | ✅ |
| 4 | Booking form | ✅ |
| 5 | Payment gateway (Midtrans) | ✅ |
| 6 | E-Ticket generation | ✅ |
| 7 | QR Code generation | ✅ |
| 8 | QR Scanner & Boarding | ✅ |
| 9 | PDF Ticket | ✅ |
| 10 | MVP Freeze & Testing | ✅ |

### 🎉 MVP COMPLETE!

All core features implemented and tested:
- 23 automated tests passing
- Full booking flow working
- Payment integration functional
- E-tickets with QR codes
- PDF download capability
- Staff boarding system

---

## License

MIT License

## Support

For support, please contact the development team.
