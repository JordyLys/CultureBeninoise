#!/bin/sh
set -e

# Créer .env minimal
if [ ! -f .env ]; then
    echo "APP_ENV=production" > .env
    echo "APP_DEBUG=false" >> .env
fi

# Démarrer PHP-FPM
php-fpm -D

# Démarrer Nginx
nginx -c /app/nginx.conf -g 'daemon off;'
