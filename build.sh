#!/bin/bash

# Build script for Render.com deployment
echo "Starting build process..."

# Install PHP and required extensions
echo "Installing PHP and extensions..."
apt-get update && apt-get install -y php8.2 php8.2-cli php8.2-common php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath

# Install Composer
echo "Installing Composer..."
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies
echo "Installing Node.js dependencies..."
npm install

# Build assets
echo "Building assets..."
npm run build

# Laravel setup
echo "Setting up Laravel..."
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link

echo "Build completed successfully!"
