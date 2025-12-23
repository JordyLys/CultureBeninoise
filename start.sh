#!/bin/bash

PORT=${PORT:-8080}
echo "🚀 Laravel starting on port $PORT"

# Utilisez le serveur PHP intégré au lieu de artisan serve
php -S 0.0.0.0:$PORT -t public
