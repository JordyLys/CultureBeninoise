#!/bin/sh

PORT_INT=$(php -r 'echo (int) getenv("PORT");')

echo "Starting Laravel on port $PORT_INT"

php artisan serve --host=0.0.0.0 --port=$PORT_INT
