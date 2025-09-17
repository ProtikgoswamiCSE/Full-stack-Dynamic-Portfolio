#!/bin/bash

echo "Testing Laravel deployment locally..."

# Build the Docker image
echo "Building Docker image..."
docker build -t portfolio-test .

# Run the container
echo "Starting container..."
docker run -d --name portfolio-test-container -p 8080:80 portfolio-test

# Wait for container to start
echo "Waiting for container to start..."
sleep 10

# Check if container is running
if docker ps | grep -q portfolio-test-container; then
    echo "✅ Container is running!"
    
    # Test the application
    echo "Testing application..."
    curl -f http://localhost:8080 > /dev/null 2>&1
    if [ $? -eq 0 ]; then
        echo "✅ Application is responding!"
    else
        echo "❌ Application is not responding"
    fi
    
    # Check logs
    echo "Container logs:"
    docker logs portfolio-test-container --tail 20
    
    # Cleanup
    echo "Cleaning up..."
    docker stop portfolio-test-container
    docker rm portfolio-test-container
else
    echo "❌ Container failed to start"
    docker logs portfolio-test-container
fi

echo "Test completed!"
