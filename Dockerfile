# Use multi-stage build
FROM php:8.3-fpm as php

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath gd intl

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy entire application
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Configure php-fpm to not daemonize
RUN sed -i 's/;daemonize = yes/daemonize = no/g' /usr/local/etc/php-fpm.conf

# Stage 2: Build frontend assets
FROM node:20-alpine as node

WORKDIR /app

# Copy package files
COPY package*.json ./
COPY vite.config.js ./
COPY postcss.config.cjs ./
COPY tailwind.config.cjs ./

# Copy resources and vendor (needed for Livewire)
COPY resources/ ./resources/
COPY --from=php /var/www/html/vendor ./vendor

# Install dependencies and build
RUN npm ci && \
    NODE_ENV=production npm run build

# Stage 3: Final image
FROM nginx:alpine

# Copy nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf

# Copy PHP-FPM and its configuration
COPY --from=php /usr/local/bin/php /usr/local/bin/php
COPY --from=php /usr/local/sbin/php-fpm /usr/local/sbin/php-fpm
COPY --from=php /usr/local/etc/php /usr/local/etc/php
COPY --from=php /usr/local/lib/php /usr/local/lib/php
COPY --from=php /usr/local/etc/php-fpm.d /usr/local/etc/php-fpm.d

# Copy application
COPY --from=php /var/www/html /var/www/html
COPY --from=node /app/public/build /var/www/html/public/build

# Copy start script
COPY start-nginx.sh /start-nginx.sh
RUN chmod +x /start-nginx.sh

ENV PORT=3000 \
    APP_ENV=production \
    APP_DEBUG=false

EXPOSE ${PORT}

CMD ["/start-nginx.sh"]