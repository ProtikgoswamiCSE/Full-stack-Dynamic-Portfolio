@echo off
echo ========================================
echo Quick Deployment Preparation
echo ========================================
echo.

echo [1/4] Installing dependencies...
call composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed!
    pause
    exit /b 1
)

call npm install
if %errorlevel% neq 0 (
    echo ERROR: NPM install failed!
    pause
    exit /b 1
)
echo ✓ Dependencies installed!

echo.
echo [2/4] Building assets...
call npm run build
if %errorlevel% neq 0 (
    echo ERROR: Asset build failed!
    pause
    exit /b 1
)
echo ✓ Assets built successfully!

echo.
echo [3/4] Checking files...
if not exist "public\build" (
    echo ERROR: Build directory not found!
    pause
    exit /b 1
)
if not exist "database\database.sqlite" (
    echo Creating SQLite database...
    type nul > database\database.sqlite
)
echo ✓ All files ready!

echo.
echo [4/4] Final preparation...
echo ✓ Project is ready for Render deployment!
echo.

echo ========================================
echo DEPLOYMENT READY!
echo ========================================
echo.
echo Next steps:
echo 1. Commit and push to GitHub:
echo    git add .
echo    git commit -m "Ready for Render deployment"
echo    git push origin main
echo.
echo 2. Go to https://dashboard.render.com
echo 3. Create new Web Service
echo 4. Connect your GitHub repository
echo 5. Select Docker environment
echo 6. Deploy!
echo.
echo Your project is 100%% ready!
echo.
pause
