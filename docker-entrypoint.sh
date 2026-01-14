#!/bin/bash
set -e

# Set default PORT if not provided
export PORT=${PORT:-80}

echo "Starting application on port $PORT"

# Generate nginx config with correct port
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/sites-available/default

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Create supervisor log directory
mkdir -p /var/log/supervisor

echo "Starting services..."
# Start supervisor (which manages nginx and php-fpm)
exec "$@"
