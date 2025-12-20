#!/bin/bash
set -e

echo "🚀 Bootstrapping Laravel..."

# Setup minimal environment
if [ ! -f .env ]; then
    echo "Creating .env..."
    cat > .env << 'ENV'
APP_NAME=Laravel
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost
DB_CONNECTION=mysql
ENV
fi

# Ensure key exists
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force --no-interaction > /dev/null 2>&1 || true
fi

# Start PHP-FPM
echo "Starting PHP-FPM..."
php-fpm -D

# Test PHP-FPM
sleep 2
if pgrep -x "php-fpm" > /dev/null; then
    echo "✅ PHP-FPM is running"
else
    echo "❌ PHP-FPM failed to start"
    exit 1
fi

# Start Nginx
echo "Starting Nginx..."
nginx -g 'daemon off;' &
NGINX_PID=$!

sleep 2
if pgrep -x "nginx" > /dev/null; then
    echo "✅ Nginx is running"
else
    echo "❌ Nginx failed to start"
    exit 1
fi

echo "✅ All services started successfully"
echo "📡 Application should be available..."

# Keep running
wait $NGINX_PID
