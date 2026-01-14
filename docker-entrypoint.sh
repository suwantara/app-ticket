#!/bin/sh
set -e

export PORT=${PORT:-80}
echo "Starting application on port $PORT"

# Generate nginx config
envsubst '${PORT}' \
  < /etc/nginx/nginx.conf.template \
  > /etc/nginx/sites-available/default

# Safe Laravel preparation
php artisan storage:link || true
php artisan optimize:clear || true

mkdir -p /var/log/supervisor

exec "$@"
