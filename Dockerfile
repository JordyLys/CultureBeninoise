FROM php:8.2-cli

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Installer les dépendances PHP
RUN composer install --no-interaction --prefer-dist

# Lier storage
RUN php artisan storage:link

# Migrer la base de données
RUN php artisan migrate --force

# Mettre en cache la config, routes et vues (remplace optimize:clear)
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Définir la commande de démarrage
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}

