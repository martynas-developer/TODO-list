FROM php:8.0.1-fpm

RUN apt-get update && \
    apt-get install -y \
    libzip-dev

RUN docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql \
    && usermod -u 1000 www-data

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www