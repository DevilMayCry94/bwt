#!/bin/bash

# Stop running containers
docker-compose down

# Build and run containers
docker-compose up --build -d

echo "Running composer install..."
docker-compose exec -it app composer install

