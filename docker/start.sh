#!/bin/bash

# Wait for database to be ready
echo "Waiting for database connection..."
max_attempts=30
attempt=0

while [ $attempt -lt $max_attempts ]; do
    if php artisan migrate:status > /dev/null 2>&1; then
        echo "Database is ready!"
        break
    fi
    echo "Database not ready, waiting... (attempt $((attempt + 1))/$max_attempts)"
    sleep 5
    attempt=$((attempt + 1))
done

if [ $attempt -eq $max_attempts ]; then
    echo "Database connection failed after $max_attempts attempts"
    echo "Continuing anyway..."
fi

# Generate application key if not exists
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:YOUR_APP_KEY_HERE" ]; then
    echo "Generating application key..."
    php artisan key:generate --no-interaction
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction || echo "Migration failed, continuing..."

# Create sessions table if it doesn't exist
echo "Creating sessions table..."
php artisan session:table --force || echo "Sessions table creation failed"
php artisan migrate --force --no-interaction || echo "Migration failed again"

# Clear and cache config
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache
chmod -R 755 /var/www/storage
chmod -R 755 /var/www/bootstrap/cache

# Start supervisor
echo "Starting services..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
