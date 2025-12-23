FROM php:8.2-apache

# Extensions PHP pour Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Apache pour Railway - CONFIGURATION CRITIQUE
RUN a2enmod rewrite
# Force Apache à utiliser le PORT de Railway
RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf
RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:${PORT}/g' /etc/apache2/sites-available/*.conf

# Définir le document root sur 'public'
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

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

# COMMANDE DE DÉMARRAGE EXPLICITE
CMD ["apache2-foreground"]
