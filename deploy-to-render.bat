@echo off
echo ========================================
echo Full-stack Dynamic Portfolio Deployment
echo ========================================
echo.

echo [1/6] Checking project structure...
if not exist "composer.json" (
    echo ERROR: composer.json not found!
    exit /b 1
)
if not exist "package.json" (
    echo ERROR: package.json not found!
    exit /b 1
)
if not exist "Dockerfile" (
    echo ERROR: Dockerfile not found!
    exit /b 1
)
echo ✓ Project structure looks good!

echo.
echo [2/6] Installing dependencies...
call composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed!
    exit /b 1
)

call npm install
if %errorlevel% neq 0 (
    echo ERROR: NPM install failed!
    exit /b 1
)
echo ✓ Dependencies installed successfully!

echo.
echo [3/6] Building assets...
call npm run build
if %errorlevel% neq 0 (
    echo ERROR: Asset build failed!
    exit /b 1
)
echo ✓ Assets built successfully!

echo.
echo [4/6] Checking database...
if not exist "database\database.sqlite" (
    echo Creating SQLite database...
    type nul > database\database.sqlite
)
echo ✓ Database ready!

echo.
echo [5/6] Testing Docker build...
docker build -t portfolio-test .
if %errorlevel% neq 0 (
    echo ERROR: Docker build failed!
    exit /b 1
)
echo ✓ Docker build successful!

echo.
echo [6/6] Final checks...
if not exist "public\build" (
    echo ERROR: Build directory not found!
    exit /b 1
)
echo ✓ All checks passed!

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
echo 2. Deploy on Render.com:
echo    - Go to your Render dashboard
echo    - Your service will auto-deploy
echo    - Monitor build logs
echo.
echo 3. Test your deployed application
echo.
pause
