#!/bin/bash

# Laravel deployment script for Render.com

echo "Starting deployment..."

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies and build assets
echo "Installing Node.js dependencies..."
npm install

echo "Building assets..."
npm run build

# Generate application key if not exists
echo "Generating application key..."
php artisan key:generate --force

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Create storage link
echo "Creating storage link..."
php artisan storage:link

# Clear and cache configuration
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
echo "Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "Deployment completed successfully!"
