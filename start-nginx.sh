#!/bin/sh

# Create nginx runtime directory
mkdir -p /run/nginx

# Set SERVER_PORT from PORT if not set
export SERVER_PORT=${SERVER_PORT:-$PORT}

# Run database migrations
cd /var/www/html
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM
php-fpm -D

# Update nginx configuration with the PORT from environment variable
sed -i "s/listen 3000/listen $PORT/g" /etc/nginx/nginx.conf

# Start Nginx
nginx -g "daemon off;" 