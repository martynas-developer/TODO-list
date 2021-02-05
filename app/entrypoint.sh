#!/bin/bash

cp -r /usr/src/cache/vendor/. /var/www/vendor/ ; chown www-data:www-data -R /var/www/vendor/
cp -r /usr/src/cache/var/. /var/www/var/ ; chown www-data:www-data -R /var/www/var/
cp -r -n /usr/src/cache/.env /var/www/

php-fpm
