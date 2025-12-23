FROM php:8.2-fpm

# Installer extensions PHP et outils système
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev zip nginx \
    && docker-php-ext-install pdo pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN php artisan storage:link
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Copier configuration Nginx
COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 8080

CMD ["sh", "-c", "nginx && php-fpm"]
