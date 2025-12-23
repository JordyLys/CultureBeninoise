FROM php:8.2-apache

# 1. INSTALLER LES EXTENSIONS PHP POUR LARAVEL
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip intl gd mbstring exif bcmath

# 2. CONFIGURER APACHE POUR RAILWAY ($PORT) ET LARAVEL
# Activer le module rewrite (ESSENTIEL pour les routes Laravel)
RUN a2enmod rewrite
# Configurer Apache pour utiliser le port fourni par Railway
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf
RUN sed -ri -e 's!Listen 80!Listen ${PORT}!g' /etc/apache2/ports.conf
RUN sed -ri -e 's!:80!:${PORT}!g' /etc/apache2/sites-available/*.conf
# Point d'entrée web vers le dossier 'public' de Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# 3. INSTALLER COMPOSER
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. COPIER LE CODE DE L'APPLICATION
COPY . .

# 5. INSTALLER LES DÉPENDANCES (MODE PRODUCTION)
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# 6. CONFIGURER LARAVEL POUR LA PRODUCTION
RUN php artisan storage:link || true \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# 7. CORRIGER LES PERMISSIONS (CRITIQUE)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Apache démarre automatiquement avec la commande par défaut 'apache2-foreground'
# Pas besoin de CMD personnalisé.
