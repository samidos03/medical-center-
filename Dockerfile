FROM php:8.4-cli
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring xml zip bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

COPY . .
RUN composer dump-autoload --optimize

RUN npm install && npm run build
RUN php artisan config:clear && php artisan view:clear

EXPOSE 8080
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}