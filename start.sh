#!/bin/bash
set -e

# Setup minimal
if [ ! -f .env ]; then
    cp .env.example .env 2>/dev/null || echo "APP_ENV=production" > .env
fi

# Démarrer les services
php-fpm -D
nginx -g 'daemon off;'
