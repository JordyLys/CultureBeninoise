#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# 1. Setup très simple
if [ ! -f .env ]; then
    cp .env.example .env 2>/dev/null || echo "APP_ENV=production" > .env
fi

# 2. Forcer production
sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env 2>/dev/null || true
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env 2>/dev/null || true

# 3. Démarrer les services SIMPLEMENT
echo "Starting PHP-FPM..."
php-fpm -D

echo "Starting Nginx..."
nginx -g 'daemon off;'
