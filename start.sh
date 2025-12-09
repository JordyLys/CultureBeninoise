#!/bin/bash
set -e

echo "=== ENVIRONMENT DEBUG ==="
echo "PORT=$PORT"
echo "APP_ENV=$APP_ENV"
echo "DB_URL=$DB_URL"
echo "========================="

echo "🔄 Running migrations..."
php artisan migrate --force --isolated

echo "🌱 Running seeders..."
php artisan db:seed --force || echo "⚠️ Seeding failed"

echo "🔗 Creating storage link..."
php artisan storage:link 2>/dev/null || echo "Storage link exists"

if [ -z "$PORT" ]; then
  export PORT=8080
  echo "⚠️ PORT was not set, using default: 8080"
fi

echo "✅ Initialization complete!"
echo "🚀 Starting Laravel server on 0.0.0.0:$PORT"

# Tester si le port est disponible
netstat -tuln | grep $PORT || echo "Port $PORT is available"

# Start the server
php artisan serve --host=0.0.0.0 --port=$PORT --no-reload &
SERVER_PID=$!

# Attendre que le serveur démarre
sleep 3

# Tester localement
curl -I http://localhost:$PORT || echo "⚠️ Local curl failed"

# Garder le serveur en vie
wait $SERVER_PID