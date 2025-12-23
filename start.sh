#!/bin/sh

echo "🚀 Starting Laravel container..."

PORT_INT=$(php -r 'echo (int) getenv("PORT");')

echo "📡 Using port $PORT_INT"

# Attendre que la DB soit prête (important)
sleep 5

# Lancer migrations si nécessaire
php artisan migrate --force || true

# Lancer le serveur
php artisan serve --host=0.0.0.0 --port=$PORT_INT
