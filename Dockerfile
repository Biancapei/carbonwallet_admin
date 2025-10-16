FROM php:8.2-cli-alpine

# Install Node.js
RUN apk add --no-cache nodejs npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install additional required extensions
RUN apk add --no-cache \
    libxml2-dev \
    && docker-php-ext-install dom xml simplexml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy all files
COPY . .

# Install Node.js dependencies
RUN npm install

# Build assets first
RUN npm run build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate Laravel key and run migrations
RUN php artisan key:generate --force
RUN php artisan migrate --force
RUN php artisan storage:link

# Set permissions
RUN chmod -R 755 storage bootstrap/cache

# Expose port
EXPOSE 8000

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
