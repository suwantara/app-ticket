#!/bin/sh
set -e

echo "Starting Laravel application..."

# Storage link
php artisan storage:link 2>/dev/null || true

# Optimize
php artisan optimize:clear 2>/dev/null || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force || echo "Migration skipped or failed"

# Create supervisor log dir
mkdir -p /var/log/supervisor

echo "Starting services..."
exec "$@"
