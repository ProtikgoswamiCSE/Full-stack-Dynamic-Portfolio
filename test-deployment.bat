@echo off
echo Testing Laravel deployment locally...

REM Build the Docker image
echo Building Docker image...
docker build -t portfolio-test .

REM Run the container
echo Starting container...
docker run -d --name portfolio-test-container -p 8080:80 portfolio-test

REM Wait for container to start
echo Waiting for container to start...
timeout /t 10 /nobreak > nul

REM Check if container is running
docker ps | findstr portfolio-test-container > nul
if %errorlevel% equ 0 (
    echo Container is running!
    
    REM Test the application
    echo Testing application...
    curl -f http://localhost:8080 > nul 2>&1
    if %errorlevel% equ 0 (
        echo Application is responding!
    ) else (
        echo Application is not responding
    )
    
    REM Check logs
    echo Container logs:
    docker logs portfolio-test-container --tail 20
    
    REM Cleanup
    echo Cleaning up...
    docker stop portfolio-test-container
    docker rm portfolio-test-container
) else (
    echo Container failed to start
    docker logs portfolio-test-container
)

echo Test completed!
pause
