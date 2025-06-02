#!/bin/sh

# Run migrations
php artisan migrate --force

# Start PHP-FPM
php-fpm -D

# Start Nginx
nginx -g "daemon off;" 