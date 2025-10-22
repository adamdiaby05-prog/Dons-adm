#!/bin/bash

# Wait for database to be ready
echo "Waiting for database connection..."
while ! php artisan migrate:status > /dev/null 2>&1; do
    echo "Database not ready, waiting..."
    sleep 2
done

echo "Database is ready!"

# Generate application key if not exists
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:YOUR_APP_KEY_HERE" ]; then
    echo "Generating application key..."
    php artisan key:generate --no-interaction
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction

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
