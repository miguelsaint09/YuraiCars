#!/bin/sh

# Create nginx runtime directory
mkdir -p /run/nginx

# Run database migrations
cd /var/www/html
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM
php-fpm -D

# Start Laravel development server with explicit host and port
php artisan serve --host=0.0.0.0 --port=${PORT:-3000} --no-reload

# Update nginx configuration with the PORT from environment variable
sed -i "s/listen 3000/listen $PORT/g" /etc/nginx/nginx.conf

# Start Nginx
nginx -g "daemon off;" 