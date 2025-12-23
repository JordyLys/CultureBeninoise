
FROM php:8.2-apache

# Extensions PHP pour Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Apache pour Railway
RUN a2enmod rewrite
RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf
RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf

WORKDIR /var/www/html

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Code
COPY . .

# Dépendances
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Laravel setup
RUN php artisan storage:link || true \
    && php artisan config:cache \
    && php artisan view:cache

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache
