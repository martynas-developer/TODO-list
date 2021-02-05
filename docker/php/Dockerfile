FROM php:8.0.1-fpm

RUN apt-get update && \
    apt-get install -y \
    libzip-dev

RUN docker-php-ext-install zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /usr/src/cache

COPY app/composer.json app/composer.lock ./

RUN composer install

WORKDIR /var/www