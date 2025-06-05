FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer.json and composer.lock
COPY composer.json composer.lock ./

# Install composer dependencies
RUN composer install --no-scripts --no-autoloader

# Copy package.json and package-lock.json
COPY package*.json ./

# Install npm dependencies
RUN npm ci

# Copy application files
COPY . .

# Generate composer autoload files
RUN composer dump-autoload --optimize

# Build Vite assets
RUN npm run build

# Start PHP-FPM
CMD ["php-fpm"] 