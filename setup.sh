#!/bin/bash

echo "========================================"
echo "  Protik Goswami Portfolio Setup"
echo "========================================"
echo

echo "[1/6] Installing PHP dependencies..."
composer install
if [ $? -ne 0 ]; then
    echo "Error: Composer install failed!"
    exit 1
fi

echo
echo "[2/6] Creating environment file..."
if [ ! -f .env ]; then
    cat > .env << EOF
APP_NAME="Protik Goswami Portfolio"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
BROADCAST_DRIVER=log
CACHE_STORE=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF
    echo "Environment file created."
else
    echo "Environment file already exists."
fi

echo
echo "[3/6] Generating application key..."
php artisan key:generate
if [ $? -ne 0 ]; then
    echo "Error: Key generation failed!"
    exit 1
fi

echo
echo "[4/6] Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo
echo "[5/6] Creating storage directories..."
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views

echo
echo "[6/6] Starting development server..."
echo
echo "========================================"
echo "  Setup Complete!"
echo "========================================"
echo
echo "Your portfolio is now running at:"
echo "http://localhost:8000"
echo
echo "Press Ctrl+C to stop the server"
echo
php artisan serve --host=0.0.0.0 --port=8000 