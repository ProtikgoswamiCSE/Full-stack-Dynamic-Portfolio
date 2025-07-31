@echo off
echo ========================================
echo   Protik Goswami Portfolio Setup
echo ========================================
echo.

echo [1/6] Installing PHP dependencies...
composer install
if %errorlevel% neq 0 (
    echo Error: Composer install failed!
    pause
    exit /b 1
)

echo.
echo [2/6] Creating environment file...
if not exist .env (
    echo APP_NAME="Protik Goswami Portfolio" > .env
    echo APP_ENV=local >> .env
    echo APP_KEY= >> .env
    echo APP_DEBUG=true >> .env
    echo APP_URL=http://localhost:8000 >> .env
    echo LOG_CHANNEL=stack >> .env
    echo LOG_DEPRECATIONS_CHANNEL=null >> .env
    echo LOG_LEVEL=debug >> .env
    echo DB_CONNECTION=mysql >> .env
    echo DB_HOST=127.0.0.1 >> .env
    echo DB_PORT=3306 >> .env
    echo DB_DATABASE=laravel >> .env
    echo DB_USERNAME=root >> .env
    echo DB_PASSWORD= >> .env
    echo BROADCAST_DRIVER=log >> .env
    echo CACHE_STORE=file >> .env
    echo FILESYSTEM_DISK=local >> .env
    echo QUEUE_CONNECTION=sync >> .env
    echo SESSION_DRIVER=file >> .env
    echo SESSION_LIFETIME=120 >> .env
    echo Environment file created.
) else (
    echo Environment file already exists.
)

echo.
echo [3/6] Generating application key...
php artisan key:generate
if %errorlevel% neq 0 (
    echo Error: Key generation failed!
    pause
    exit /b 1
)

echo.
echo [4/6] Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo [5/6] Creating storage directories...
if not exist "storage\framework\cache\data" mkdir "storage\framework\cache\data"
if not exist "storage\framework\sessions" mkdir "storage\framework\sessions"
if not exist "storage\framework\views" mkdir "storage\framework\views"

echo.
echo [6/6] Starting development server...
echo.
echo ========================================
echo   Setup Complete!
echo ========================================
echo.
echo Your portfolio is now running at:
echo http://localhost:8000
echo.
echo Press Ctrl+C to stop the server
echo.
php artisan serve --host=0.0.0.0 --port=8000 