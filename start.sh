#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# =====================================
# 1. SETUP .ENV FILE
# =====================================
if [ ! -f .env ]; then
    echo "📄 Creating .env file from example..."
    if [ -f .env.example ]; then
        cp .env.example .env
    else
        echo "❌ No .env.example found! Creating minimal .env..."
        touch .env
        echo "APP_NAME=Laravel" >> .env
        echo "APP_ENV=production" >> .env
        echo "APP_DEBUG=false" >> .env
        echo "DB_CONNECTION=mysql" >> .env
    fi
fi

# =====================================
# 2. ENSURE PRODUCTION SETTINGS
# =====================================
# Force production environment
sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env

# Change sqlite to mysql for Railway
if grep -q "^DB_CONNECTION=sqlite" .env; then
    echo "⚠️  Changing DB_CONNECTION from sqlite to mysql for Railway..."
    sed -i 's/^DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env
fi

# =====================================
# 3. GENERATE APP_KEY IF MISSING
# =====================================
if ! grep -q "^APP_KEY=" .env || grep -q "^APP_KEY=$" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force --no-interaction
fi

# =====================================
# 4. WAIT FOR DATABASE
# =====================================
wait_for_db() {
    if [ -n "$DB_HOST" ] && [ -n "$DB_PORT" ]; then
        echo "⏳ Waiting for database at $DB_HOST:$DB_PORT..."

        # Try using nc (netcat) if available
        if command -v nc &> /dev/null; then
            while ! nc -z $DB_HOST $DB_PORT; do
                sleep 1
            done
        # Fallback: use PHP to test connection
        else
            echo "📊 Using PHP to test database connection..."
            until php -r "
                try {
                    \$pdo = new PDO('mysql:host=$DB_HOST;port=$DB_PORT', '$DB_USERNAME', '$DB_PASSWORD');
                    \$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    echo 'Database ready!';
                    exit(0);
                } catch (Exception \$e) {
                    // Wait and retry
                    sleep(1);
                }
            " 2>/dev/null; do
                sleep 1
            done
        fi

        echo "✅ Database is ready!"
    else
        echo "ℹ️  No database configuration found, skipping wait..."
    fi
}
wait_for_db

# =====================================
# 5. DATABASE MIGRATIONS & SEEDERS
# =====================================
echo "🔄 Running migrations..."
php artisan migrate --force --no-interaction

echo "🌱 Running seeders..."
php artisan db:seed --force --no-interaction

# =====================================
# 6. OPTIMIZATIONS
# =====================================
echo "⚡ Optimizing application..."
php artisan optimize
php artisan storage:link

# =====================================
# 7. START SERVICES
# =====================================
echo "🚀 Starting PHP-FPM..."
php-fpm -D

echo "🌐 Starting Nginx..."
nginx -g 'daemon off;'
