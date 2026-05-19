FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    git curl zip unzip \
    libzip-dev libpng-dev libonig-dev libxml2-dev oniguruma-dev \
    nginx supervisor \
    && docker-php-ext-install pdo_mysql mbstring xml zip bcmath gd opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN cp .env.example .env 2>/dev/null || true
RUN php artisan config:clear

RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080

CMD ["sh", "-c", "php artisan migrate --force && php artisan config:cache && php artisan route:cache && php -S 0.0.0.0:8080 -t public"]