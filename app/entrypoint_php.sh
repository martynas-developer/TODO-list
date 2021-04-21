#!/bin/bash

php /usr/bin/composer install

php bin/console --no-interaction doctrine:migrations:migrate

# print env variables for cron
printenv | grep -v "no_proxy" >> /etc/environment

cron -f & php-fpm
