# fpm for fast cgi
FROM php:8.3-fpm

# Install node and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y \
    nodejs \
    # PHP and other dependencies
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
    pkg-config \
    && npm install -g npm@latest

# i extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath gd intl

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy package files first
COPY package*.json ./
COPY vite.config.js ./
COPY postcss.config.cjs ./
COPY tailwind.config.cjs ./

# Install npm dependencies
RUN npm ci

# Copy the rest of the application
COPY . .

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
ENV NODE_ENV=production
RUN npm run build

# permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

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