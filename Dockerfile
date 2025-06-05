FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure zip && \
    docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    opcache \
    dom \
    xml

# Install additional PHP extensions
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first
COPY composer.json composer.lock ./

# Set composer environment
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_PROCESS_TIMEOUT=600

# Install composer dependencies
RUN composer install \
    --prefer-dist \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --no-autoloader

# Copy the rest of the application code
COPY . .

# Generate the autoloader
RUN composer dump-autoload --optimize

# Install and build frontend assets
COPY package*.json ./
RUN npm ci && npm run build

# PHP configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Start PHP-FPM
CMD ["php-fpm"] 