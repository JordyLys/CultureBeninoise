#!/bin/bash
set -e

# Créer .env
cp .env.example .env 2>/dev/null || touch .env
sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env

# Générer APP_KEY si besoin
php artisan key:generate --force --no-interaction 2>/dev/null || true

# Migrations
php artisan migrate --force --no-interaction || true

# Démarrer les services
php-fpm &
nginx -g 'daemon off;'
