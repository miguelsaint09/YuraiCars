#!/bin/bash

# Run migrations
php artisan migrate --force

# Start php-fpm
exec php-fpm -y /usr/local/etc/php-fpm.d/www.conf 