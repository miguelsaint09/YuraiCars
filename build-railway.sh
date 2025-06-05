#!/bin/bash

# Railway Build Script - YuraiCars Ultra Premium
echo "🚗 Building YuraiCars Ultra Premium Experience..."

# Install PHP dependencies (production)
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies  
echo "📦 Installing Node dependencies..."
npm ci

# Build assets with Laravel Mix
echo "🎨 Building premium assets..."
npm run production

# Verify assets were built
echo "✅ Verifying build..."
ls -la public/css/ public/js/

# Laravel optimizations
echo "🔧 Optimizing Laravel..."
php artisan key:generate --force
php artisan storage:link --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Database migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 755 storage bootstrap/cache

# Final optimization
echo "⚡ Final optimization..."
php artisan optimize

echo "✅ YuraiCars Ultra Premium build complete!" 