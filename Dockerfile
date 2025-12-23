FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-interaction --prefer-dist
RUN php artisan optimize:clear
RUN php artisan storage:link
RUN php artisan migrate --force

CMD php artisan serve --host=0.0.0.0 --port=$PORT
