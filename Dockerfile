# Use multi-stage build
FROM php:8.3-fpm-alpine as php

# Install system dependencies
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    icu-dev \
    postgresql-dev \
    oniguruma-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath gd intl

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy entire application
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Patch ServeCommand.php
RUN sed -i 's/$port = $port ?: 8000;/$port = (int) ($port ?: 8000);/' vendor/laravel/framework/src/Illuminate/Foundation/Console/ServeCommand.php

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Stage 2: Build frontend assets
FROM node:20-alpine as node

WORKDIR /app

# Copy package files and install dependencies
COPY package*.json ./
RUN npm install --no-audit --no-fund

# Copy build configuration
COPY vite.config.js ./
COPY postcss.config.cjs ./
COPY tailwind.config.cjs ./

# Copy resources and vendor (needed for Livewire)
COPY resources/ ./resources/
COPY --from=php /var/www/html/vendor ./vendor

# Build assets
RUN NODE_ENV=production npm run build

# Stage 3: Final image with PHP-FPM and Nginx
FROM php:8.3-fpm-alpine

# Install nginx and required PHP extensions
RUN apk add --no-cache \
    nginx \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    icu-dev \
    postgresql-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath gd intl

# Configure PHP-FPM
RUN echo "pm.max_children = 10" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo "pm.start_servers = 2" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo "pm.min_spare_servers = 1" >> /usr/local/etc/php-fpm.d/zz-docker.conf \
    && echo "pm.max_spare_servers = 3" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Set working directory
WORKDIR /var/www/html

# Copy nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf

# Copy application
COPY --from=php /var/www/html /var/www/html
COPY --from=node /app/public/build /var/www/html/public/build

# Copy start script
COPY start-nginx.sh /start-nginx.sh
RUN chmod +x /start-nginx.sh

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && mkdir -p /run/nginx

ENV PORT=3000 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    LOG_LEVEL=info

EXPOSE ${PORT}

CMD ["/start-nginx.sh"]