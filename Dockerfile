FROM php:8.2-cli-alpine

# Install Node.js and required dependencies for PHP extensions
RUN apk add --no-cache \
    nodejs npm \
    oniguruma-dev \
    libxml2-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install DOM/XML extensions
RUN docker-php-ext-install dom xml simplexml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy all files
COPY . .

# Create .env file for Laravel
RUN echo "APP_NAME=CarbonAI" > .env && \
    echo "APP_ENV=production" >> .env && \
    echo "APP_KEY=" >> .env && \
    echo "APP_DEBUG=false" >> .env && \
    echo "APP_URL=https://carbonwallet-admin-xprl.onrender.com" >> .env && \
    echo "FORCE_HTTPS=true" >> .env && \
    echo "ASSET_URL=https://carbonwallet-admin-xprl.onrender.com" >> .env && \
    echo "" >> .env && \
    echo "LOG_CHANNEL=stderr" >> .env && \
    echo "LOG_DEPRECATIONS_CHANNEL=null" >> .env && \
    echo "LOG_LEVEL=debug" >> .env && \
    echo "" >> .env && \
    echo "DB_CONNECTION=sqlite" >> .env && \
    echo "DB_DATABASE=/app/database/database.sqlite" >> .env && \
    echo "" >> .env && \
    echo "BROADCAST_DRIVER=log" >> .env && \
    echo "CACHE_DRIVER=file" >> .env && \
    echo "FILESYSTEM_DISK=local" >> .env && \
    echo "QUEUE_CONNECTION=sync" >> .env && \
    echo "SESSION_DRIVER=file" >> .env && \
    echo "SESSION_LIFETIME=120" >> .env && \
    echo "" >> .env && \
    echo "MAIL_MAILER=log" >> .env && \
    echo "MAIL_HOST=mailpit" >> .env && \
    echo "MAIL_PORT=1025" >> .env && \
    echo "MAIL_USERNAME=null" >> .env && \
    echo "MAIL_PASSWORD=null" >> .env && \
    echo "MAIL_ENCRYPTION=null" >> .env

# Install Node.js dependencies
RUN npm install

# Build assets first
RUN npm run build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Create database directory and file
RUN mkdir -p database && touch database/database.sqlite

# Generate Laravel key and run migrations
RUN php artisan key:generate --force
RUN php artisan migrate --force
RUN php artisan db:seed --force
RUN php artisan storage:link --force

# Set permissions
RUN chmod -R 755 storage bootstrap/cache

# Expose port
EXPOSE 8000

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
