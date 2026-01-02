FROM php:8.2-apache

# Extensions PHP nécessaires à Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Activer rewrite
RUN a2enmod rewrite

# Définir le DocumentRoot Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le code
COPY . .

# Installer dépendances PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Optimisations Laravel
RUN php artisan storage:link || true \
    && php artisan config:clear \
    && php artisan config:cache \
    && php artisan view:clear \
    && php artisan view:cache

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Port exposé (Railway injecte $PORT)
EXPOSE 80

# Démarrage Apache avec port Railway
CMD sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf \
 && sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/*.conf \
 && apache2-foreground
