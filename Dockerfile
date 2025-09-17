# Multi-stage build for Laravel app with nginx
FROM php:8.2-fpm as php

# Install system dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
       libsqlite3-dev sqlite3 \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true

# Copy the app
COPY . .

# Ensure storage and bootstrap cache are writable
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Final stage with nginx
FROM nginx:1.27-alpine

# Install PHP-FPM
RUN apk add --no-cache \
    php82 \
    php82-fpm \
    php82-pdo \
    php82-pdo_sqlite \
    php82-mbstring \
    php82-xml \
    php82-json \
    php82-openssl \
    php82-tokenizer \
    php82-ctype \
    php82-fileinfo \
    php82-bcmath \
    php82-gd \
    php82-zip \
    php82-session \
    php82-tokenizer \
    php82-json \
    php82-curl \
    php82-opcache

# Copy PHP application from previous stage
COPY --from=php /var/www/html /var/www/html

# Copy nginx configuration
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Create nginx user and set permissions
RUN addgroup -g 1001 -S nginx && \
    adduser -S -D -H -u 1001 -h /var/cache/nginx -s /sbin/nologin -G nginx -g nginx nginx

# Set proper permissions
RUN chown -R nginx:nginx /var/www/html && \
    chmod -R 755 /var/www/html

# Create startup script
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'set -e' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Generate APP_KEY if not set' >> /start.sh && \
    echo 'if [ -z "$APP_KEY" ]; then' >> /start.sh && \
    echo '    export APP_KEY=$(php -r "echo base64_encode(random_bytes(32));")' >> /start.sh && \
    echo 'fi' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Set production environment variables' >> /start.sh && \
    echo 'export APP_ENV=${APP_ENV:-production}' >> /start.sh && \
    echo 'export APP_DEBUG=${APP_DEBUG:-false}' >> /start.sh && \
    echo 'export DB_CONNECTION=${DB_CONNECTION:-sqlite}' >> /start.sh && \
    echo 'export DB_DATABASE=${DB_DATABASE:-/var/www/html/database/database.sqlite}' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Create .env file' >> /start.sh && \
    echo 'cat > /var/www/html/.env << EOF' >> /start.sh && \
    echo 'APP_NAME="${APP_NAME:-Full-stack Dynamic Portfolio}"' >> /start.sh && \
    echo 'APP_ENV=${APP_ENV}' >> /start.sh && \
    echo 'APP_KEY=${APP_KEY}' >> /start.sh && \
    echo 'APP_DEBUG=${APP_DEBUG}' >> /start.sh && \
    echo 'APP_URL=${APP_URL:-http://localhost}' >> /start.sh && \
    echo '' >> /start.sh && \
    echo 'LOG_CHANNEL=stack' >> /start.sh && \
    echo 'LOG_LEVEL=error' >> /start.sh && \
    echo '' >> /start.sh && \
    echo 'DB_CONNECTION=${DB_CONNECTION}' >> /start.sh && \
    echo 'DB_DATABASE=${DB_DATABASE}' >> /start.sh && \
    echo '' >> /start.sh && \
    echo 'CACHE_DRIVER=file' >> /start.sh && \
    echo 'SESSION_DRIVER=file' >> /start.sh && \
    echo 'SESSION_LIFETIME=120' >> /start.sh && \
    echo 'EOF' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Run Laravel optimizations' >> /start.sh && \
    echo 'cd /var/www/html' >> /start.sh && \
    echo 'php artisan config:cache' >> /start.sh && \
    echo 'php artisan route:cache' >> /start.sh && \
    echo 'php artisan view:cache' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Start services' >> /start.sh && \
    echo 'php-fpm82 -D' >> /start.sh && \
    echo 'nginx -g "daemon off;"' >> /start.sh && \
    chmod +x /start.sh

# Expose port 80
EXPOSE 80

# Start both services
CMD ["/start.sh"]


