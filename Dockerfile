# Multi-stage build for Laravel app with nginx
FROM php:8.2-fpm as php

# Install system dependencies including Node.js
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
       libsqlite3-dev sqlite3 curl \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./
# Avoid running Composer scripts before the full app (and artisan) exist
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader

# Copy the app first (needed for Vite build)
COPY . .

# Install Node dependencies and build assets
RUN npm install && npm run build

# Now run full install with scripts enabled (service provider discovery, etc.)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Ensure storage and bootstrap cache are writable
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Final stage with nginx
FROM nginx:1.27-alpine

# Install PHP-FPM, Node.js and required extensions
RUN apk add --no-cache \
    php82 \
    php82-fpm \
    php82-pdo \
    php82-pdo_sqlite \
    php82-mbstring \
    php82-xml \
    php82-dom \
    php82-json \
    php82-openssl \
    php82-tokenizer \
    php82-ctype \
    php82-fileinfo \
    php82-bcmath \
    php82-gd \
    php82-zip \
    php82-session \
    php82-curl \
    php82-opcache \
    php82-intl \
    php82-simplexml \
    nodejs \
    npm

# Copy PHP application from previous stage
COPY --from=php /var/www/html /var/www/html

# Copy nginx configuration
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Configure PHP-FPM to listen on TCP for nginx
RUN sed -i 's#^listen = .*#listen = 127.0.0.1:9000#' /etc/php82/php-fpm.d/www.conf \
    && sed -i 's#^user = .*#user = nginx#' /etc/php82/php-fpm.d/www.conf \
    && sed -i 's#^group = .*#group = nginx#' /etc/php82/php-fpm.d/www.conf

# Nginx user already exists in the base image; just ensure permissions

# Set proper permissions
RUN chown -R nginx:nginx /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    (chmod 664 /var/www/html/database/database.sqlite 2>/dev/null || true)

# Create symlink for php command
RUN ln -s /usr/bin/php82 /usr/bin/php

# Create startup script
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'set -e' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Generate APP_KEY if not set' >> /start.sh && \
    echo 'if [ -z "$APP_KEY" ]; then' >> /start.sh && \
    echo '    export APP_KEY="base64:$(php -r "echo base64_encode(random_bytes(32));")"' >> /start.sh && \
    echo 'fi' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Set production environment variables' >> /start.sh && \
    echo 'export APP_ENV=${APP_ENV:-production}' >> /start.sh && \
    echo 'export APP_DEBUG=${APP_DEBUG:-false}' >> /start.sh && \
    echo 'export DB_CONNECTION=${DB_CONNECTION:-sqlite}' >> /start.sh && \
    echo 'export DB_DATABASE=${DB_DATABASE:-/var/www/html/database/database.sqlite}' >> /start.sh && \
    echo 'export PORT=${PORT:-8080}' >> /start.sh && \
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
    echo '# Run Laravel setup and optimizations' >> /start.sh && \
    echo 'cd /var/www/html' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Build assets if not already built' >> /start.sh && \
    echo 'if [ ! -d "public/build" ]; then' >> /start.sh && \
    echo '    echo "Building assets..."' >> /start.sh && \
    echo '    npm install && npm run build' >> /start.sh && \
    echo 'fi' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Ensure storage directories exist and are writable' >> /start.sh && \
    echo 'mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views' >> /start.sh && \
    echo 'mkdir -p database' >> /start.sh && \
    echo 'touch database/database.sqlite' >> /start.sh && \
    echo 'chown -R nginx:nginx storage bootstrap/cache database' >> /start.sh && \
    echo 'chmod -R 775 storage bootstrap/cache' >> /start.sh && \
    echo 'chmod 664 database/database.sqlite' >> /start.sh && \
    echo 'touch storage/logs/laravel.log' >> /start.sh && \
    echo 'chown nginx:nginx storage/logs/laravel.log' >> /start.sh && \
    echo 'chmod 664 storage/logs/laravel.log' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Run database migrations' >> /start.sh && \
    echo 'php artisan migrate --force || echo "Migration failed, continuing..."' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Seed database if needed' >> /start.sh && \
    echo 'php artisan db:seed --force || echo "Seeding failed, continuing..."' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Clear and cache configurations' >> /start.sh && \
    echo 'php artisan config:clear || echo "Config clear failed"' >> /start.sh && \
    echo 'php artisan cache:clear || echo "Cache clear failed"' >> /start.sh && \
    echo 'php artisan view:clear || echo "View clear failed"' >> /start.sh && \
    echo 'php artisan route:clear || echo "Route clear failed"' >> /start.sh && \
    echo '' >> /start.sh && \
    echo 'php artisan config:cache || echo "Config cache failed"' >> /start.sh && \
    echo 'php artisan route:cache || echo "Route cache failed"' >> /start.sh && \
    echo 'php artisan view:cache || echo "View cache failed"' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Configure nginx to listen on Render $PORT' >> /start.sh && \
    echo 'sed -i "s/listen 80 default_server;/listen ${PORT} default_server;/" /etc/nginx/conf.d/default.conf' >> /start.sh && \
    echo '' >> /start.sh && \
    echo '# Start services' >> /start.sh && \
    echo 'php-fpm82 -D' >> /start.sh && \
    echo 'nginx -g "daemon off;"' >> /start.sh && \
    chmod +x /start.sh

# Expose port 80
EXPOSE 80

# Start both services
CMD ["/start.sh"]


