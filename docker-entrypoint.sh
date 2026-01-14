#!/bin/bash
set -e

# Set default PORT if not provided
export PORT=${PORT:-80}

echo "Starting application on port $PORT"

# Parse DATABASE_URL if provided by Railway
if [ -n "$DATABASE_URL" ]; then
    echo "Parsing DATABASE_URL..."
    # Extract components from DATABASE_URL
    # Format: mysql://user:password@host:port/database
    export DB_CONNECTION="mysql"
    export DB_HOST=$(echo $DATABASE_URL | sed -E 's/.*@([^:]+):.*/\1/')
    export DB_PORT=$(echo $DATABASE_URL | sed -E 's/.*:([0-9]+)\/.*/\1/')
    export DB_DATABASE=$(echo $DATABASE_URL | sed -E 's/.*\/([^?]+).*/\1/')
    export DB_USERNAME=$(echo $DATABASE_URL | sed -E 's/mysql:\/\/([^:]+):.*/\1/')
    export DB_PASSWORD=$(echo $DATABASE_URL | sed -E 's/mysql:\/\/[^:]+:([^@]+)@.*/\1/')
    echo "Database configured: $DB_HOST:$DB_PORT/$DB_DATABASE"
fi

# Generate nginx config with correct port
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/sites-available/default

# Check if APP_KEY is set, if not generate one
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:placeholder" ]; then
    echo "No APP_KEY found, generating..."
    php artisan key:generate --force
else
    echo "APP_KEY already set, skipping generation"
fi

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Clear cached config (to pick up new env vars)
php artisan config:clear 2>/dev/null || true

# Cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "Running migrations..."
php artisan migrate --force || echo "Migration failed, continuing anyway..."

# Create supervisor log directory
mkdir -p /var/log/supervisor

echo "Starting services..."
# Start supervisor (which manages nginx and php-fpm)
exec "$@"
