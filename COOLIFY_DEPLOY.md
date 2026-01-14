# Panduan Deploy Laravel di Coolify (VM VirtualBox)

Guide lengkap untuk deploy project app-ticket ke Coolify di VM Ubuntu.

## Prerequisites

-   VirtualBox dengan Ubuntu Server/Desktop (22.04 LTS recommended)
-   RAM: 4GB minimum
-   Storage: 20GB free
-   Network: Bridged Adapter

---

## Part 1: Setup VirtualBox Network

### 1.1 Konfigurasi Bridged Adapter

1. **Matikan VM** jika sedang running
2. Buka **Settings** → **Network**
3. Adapter 1:
    - ✅ Enable Network Adapter
    - Attached to: **Bridged Adapter**
    - Name: Pilih WiFi/Ethernet adapter yang sedang digunakan
4. **OK** dan start VM

### 1.2 Cek IP Address VM

```bash
ip addr show | grep "inet "
```

Catat IP yang seperti `192.168.x.x` - ini yang akan diakses teman kampus.

---

## Part 2: Install Coolify

### 2.1 Update System

```bash
sudo apt update && sudo apt upgrade -y
```

### 2.2 Install Docker (jika belum ada)

```bash
curl -fsSL https://get.docker.com | sh
sudo usermod -aG docker $USER
# Logout dan login kembali, atau:
newgrp docker
```

### 2.3 Install Coolify

```bash
curl -fsSL https://cdn.coollabs.io/coolify/install.sh | sudo bash
```

Tunggu 5-10 menit sampai selesai.

### 2.4 Akses Coolify Dashboard

Buka browser: `http://[IP-VM]:8000`

1. Buat akun admin
2. Login ke dashboard

---

## Part 3: Setup Database PostgreSQL

### 3.1 Tambah Database

1. Klik **Resources** → **+ New**
2. Pilih **Database** → **PostgreSQL**
3. Konfigurasi:
    - Name: `app-ticket-db`
    - Postgres Database: `app_ticket`
    - Postgres User: `app_ticket`
    - Postgres Password: (generate atau buat sendiri)
4. **Deploy**

### 3.2 Catat Connection Details

Setelah deploy, catat:

-   Host: `app-ticket-db` (internal)
-   Port: `5432`
-   Database: `app_ticket`
-   Username: `app_ticket`
-   Password: (yang dibuat tadi)

---

## Part 4: Deploy Laravel Application

### 4.1 Tambah Application

1. Klik **Resources** → **+ New**
2. Pilih **Application**
3. Source: **Public Repository** atau **GitHub** (jika sudah connect)
4. Masukkan URL repo: `https://github.com/suwantara/app-ticket`
5. Branch: `deploy`

### 4.2 Build Configuration

Pilih **Nixpacks** (recommended) atau **Dockerfile**.

Jika menggunakan Dockerfile, buat file berikut di repo:

```dockerfile
FROM php:8.4-fpm

# Dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev \
    libpq-dev zip unzip nginx supervisor \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 storage bootstrap/cache

COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
```

### 4.3 Environment Variables

Di Coolify, tambahkan environment variables:

```env
APP_NAME=SemabuHills
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_NEW_KEY
APP_URL=http://[IP-VM]

DB_CONNECTION=pgsql
DB_HOST=app-ticket-db
DB_PORT=5432
DB_DATABASE=app_ticket
DB_USERNAME=app_ticket
DB_PASSWORD=[PASSWORD_DARI_STEP_3]

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false
```

### 4.4 Generate APP_KEY

Jalankan di laptop lokal:

```bash
php artisan key:generate --show
```

Copy hasilnya ke environment variable `APP_KEY`.

### 4.5 Deploy

Klik **Deploy** dan tunggu sampai selesai.

---

## Part 5: Setup Domain/URL

### 5.1 Akses via IP

Setelah deploy berhasil, akses:

```
http://[IP-VM]:3000
```

(Port mungkin berbeda, cek di Coolify)

### 5.2 Share ke Teman Kampus

Pastikan:

1. VM menggunakan **Bridged Network**
2. Laptop teman **terhubung ke jaringan WiFi yang sama**
3. Berikan URL: `http://192.168.x.x:3000`

---

## Part 6: Expose ke Internet (Opsional)

Jika ingin akses dari luar jaringan kampus:

### 6.1 Ngrok (Paling Mudah)

```bash
# Install ngrok
curl -sSL https://ngrok-agent.s3.amazonaws.com/ngrok.asc | sudo tee /etc/apt/trusted.gpg.d/ngrok.asc
echo "deb https://ngrok-agent.s3.amazonaws.com buster main" | sudo tee /etc/apt/sources.list.d/ngrok.list
sudo apt update && sudo apt install ngrok

# Setup authtoken (daftar gratis di ngrok.com)
ngrok config add-authtoken YOUR_TOKEN

# Expose port
ngrok http 3000
```

Ngrok akan memberikan URL public seperti: `https://abc123.ngrok.io`

### 6.2 Cloudflare Tunnel (Alternatif)

```bash
# Install cloudflared
curl -L https://github.com/cloudflare/cloudflared/releases/latest/download/cloudflared-linux-amd64 -o cloudflared
chmod +x cloudflared
sudo mv cloudflared /usr/local/bin/

# Quick tunnel (tanpa domain)
cloudflared tunnel --url http://localhost:3000
```

---

## Troubleshooting

### VM tidak bisa diakses dari laptop lain

-   Pastikan menggunakan **Bridged Adapter**
-   Cek firewall: `sudo ufw status` → `sudo ufw allow 3000`
-   Pastikan di jaringan yang sama

### Build gagal

-   Cek logs di Coolify dashboard
-   Pastikan environment variables sudah di-set

### Database connection error

-   Pastikan PostgreSQL service running
-   Cek hostname: gunakan nama service (`app-ticket-db`), bukan `localhost`

---

## Quick Checklist

-   [ ] VirtualBox network: Bridged Adapter
-   [ ] Coolify installed dan running
-   [ ] PostgreSQL database created
-   [ ] Laravel app deployed
-   [ ] Environment variables configured
-   [ ] APP_KEY generated
-   [ ] Test akses dari laptop lain

---

**Selamat ujian! 🎓**
