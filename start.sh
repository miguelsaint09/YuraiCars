#!/bin/bash

# Convert PORT to integer if it exists
if [ -z "$PORT" ]; then
    PORT=8000
else
    PORT=$(($PORT + 0))
fi

# Run database migrations
php artisan migrate --force

# Start the server with explicit port conversion
php artisan serve --host=0.0.0.0 --port="$PORT" 