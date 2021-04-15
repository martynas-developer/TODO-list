#!/bin/bash

php /usr/bin/composer install

# print env variables for cron
printenv | grep -v "no_proxy" >> /etc/environment

cron -f & php-fpm
