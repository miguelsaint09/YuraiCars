#!/bin/bash

# Railway Build Script for YuraiCars
echo "🚀 Starting YuraiCars Railway Build Process..."

# Install PHP dependencies (production only)
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies
echo "📦 Installing Node dependencies..."
npm ci --only=production

# Build frontend assets
echo "🏗️  Building frontend assets..."
npm run build

# Verify build output
echo "✅ Verifying build output..."
ls -la public/build/

# Laravel optimizations
echo "🔧 Optimizing Laravel..."
php artisan key:generate --force
php artisan storage:link --force
php artisan config:cache
php artisan route:cache  
php artisan view:cache
php artisan event:cache

# Database setup
echo "🗄️  Setting up database..."
php artisan migrate --force

# Seed database (optional)
php artisan db:seed --force || echo "⚠️  Database seeding failed or not needed"

# File permissions
echo "🔒 Setting file permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Final optimization
echo "⚡ Final optimization..."
php artisan optimize

echo "✅ Railway build completed successfully!" 