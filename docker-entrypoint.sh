#!/bin/bash
set -e

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Create supervisor log directory
mkdir -p /var/log/supervisor

# Start supervisor (which manages nginx and php-fpm)
exec "$@"
