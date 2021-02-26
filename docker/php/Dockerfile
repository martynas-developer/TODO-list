FROM php:8.0.1-fpm

RUN apt-get update && \
    apt-get install -y \
    libzip-dev

RUN docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /usr/src/cache

COPY app/composer.json app/composer.lock ./

RUN composer install

WORKDIR /var/www

#@TODO fix permissions
#COPY --chown=1000:1000 app /var/www
#RUN PATH=$PATH:/var/www/vendor/bin:bin

#RUN chown -R www-data:www-data /var/www
#USER www-data