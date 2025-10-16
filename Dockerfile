FROM node:20-alpine

# Install PHP and required extensions
RUN apk add --no-cache \
    php82 \
    php82-cli \
    php82-common \
    php82-mysqli \
    php82-zip \
    php82-gd \
    php82-mbstring \
    php82-curl \
    php82-xml \
    php82-bcmath \
    php82-pdo \
    php82-pdo_mysql \
    php82-fileinfo \
    php82-tokenizer \
    php82-openssl \
    curl

# Create symbolic link for php command
RUN ln -sf /usr/bin/php82 /usr/bin/php

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy package files first for better caching
COPY package*.json ./

# Install Node.js dependencies
RUN npm install

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy application code
COPY . .

# Build assets
RUN npm run build

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
