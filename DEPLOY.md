# Deployment Guide - Railway

Panduan deploy project **Ferry Ticket Sanur-Nusa Penida** ke Railway.

## Prerequisites

-   Akun [Railway](https://railway.app) (bisa login dengan GitHub)
-   Repository di GitHub

## Langkah Deploy

### 1. Create New Project di Railway

1. Buka [Railway Dashboard](https://railway.app/dashboard)
2. Klik **New Project** → **Deploy from GitHub Repo**
3. Pilih repository `suwantara/app-ticket`
4. Pilih branch `deploy`

### 2. Add MySQL Database

1. Di project Railway, klik **New** → **Database** → **MySQL**
2. Railway akan otomatis mengisi environment variables database

### 3. Setup Environment Variables

Klik service → **Variables** → tambahkan:

```
APP_NAME=Ferry Ticket Sanur-Nusa Penida
APP_ENV=production
APP_KEY=  (generate dengan tombol "Generate")
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=database
QUEUE_CONNECTION=sync
CACHE_STORE=file
FILESYSTEM_DISK=local

MIDTRANS_SERVER_KEY=your-sandbox-key
MIDTRANS_CLIENT_KEY=your-sandbox-key
MIDTRANS_IS_PRODUCTION=false
```

### 4. Generate APP_KEY

Di Railway Variables, buat APP_KEY dengan:

1. Jalankan lokal: `php artisan key:generate --show`
2. Copy hasil ke variable `APP_KEY`

### 5. Deploy

Railway akan auto-deploy setelah push ke branch `deploy`.

## Workflow Development

```
Development → deploy (staging) → main (production)
```

1. **Testing changes**: Push ke branch `deploy`
2. **Railway auto-redeploy**: Setiap push akan trigger redeploy
3. **After verified**: Merge `deploy` ke `main`

## Commands

```bash
# Switch ke branch deploy
git checkout deploy

# Push changes untuk redeploy
git add .
git commit -m "fix: your message"
git push origin deploy

# Merge ke main setelah fix
git checkout main
git merge deploy
git push origin main
```

## Troubleshooting

### Build Failed

-   Cek logs di Railway dashboard
-   Pastikan semua dependencies ada di `composer.json`

### Database Error

-   Pastikan MySQL service sudah running
-   Cek environment variables sudah ter-link

### 502 Error

-   Tunggu beberapa menit untuk cold start
-   Cek `APP_KEY` sudah di-set

## Free Tier Limits

-   $5 credit per bulan
-   ~500 jam runtime
-   Cukup untuk demo dan presentasi

## URL Aplikasi

Setelah deploy, Railway akan memberikan URL seperti:
`https://app-ticket-production.up.railway.app`
