FROM php:8.4-apache

RUN rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf \
    && a2enmod mpm_prefork rewrite

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring xml zip bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction
RUN composer dump-autoload --optimize

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i "s/Listen 80/Listen 8080/" /etc/apache2/ports.conf
RUN sed -i "s/:80/:8080/" /etc/apache2/sites-available/000-default.conf

EXPOSE 8080

CMD ["sh", "-c", "php artisan migrate --force && apache2-foreground"]