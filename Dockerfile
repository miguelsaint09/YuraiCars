# fpm for fast cgi
FROM php:8.3-fpm

# i system deps
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
    bash \
    libicu-dev \
    icu-devtools \
    pkg-config

# i extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath gd intl

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# std working dir
WORKDIR /var/www/html
COPY . /var/www/html

# permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

# Copy php-fpm config
COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Set environment variable defaults
ENV PORT=3000 \
    PHP_FPM_PORT=3000 \
    FPM_PORT=3000

# Expose port from environment
EXPOSE ${PORT}

# Start php-fpm
CMD ["php-fpm", "-F"]