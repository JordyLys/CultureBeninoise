#!/bin/bash
# Fichier: start.sh

# Attendre que la BD soit prête (optionnel mais recommandé)
if [ -n "$DB_HOST" ]; then
  echo "Waiting for database at $DB_HOST:$DB_PORT..."
  while ! nc -z $DB_HOST $DB_PORT; do
    sleep 1
  done
  echo "Database is ready!"
fi

# Exécuter les migrations et seeders
php artisan migrate --force --no-interaction
php artisan db:seed --force --no-interaction

# Démarrer PHP-FPM en arrière-plan
php-fpm &

# Démarrer Nginx au premier plan
nginx -g 'daemon off;'
