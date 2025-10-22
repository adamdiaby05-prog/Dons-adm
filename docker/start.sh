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

# Test database connection
echo "Testing database connection..."
PGPASSWORD=$DB_PASSWORD psql -h $DB_HOST -p $DB_PORT -U $DB_USERNAME -d $DB_DATABASE -f /var/www/database/sql/test_connection.sql || echo "Database connection test failed"

# Create sessions table directly with SQL
echo "Creating sessions table with SQL..."
PGPASSWORD=$DB_PASSWORD psql -h $DB_HOST -p $DB_PORT -U $DB_USERNAME -d $DB_DATABASE -f /var/www/database/sql/create_sessions_table.sql || echo "Sessions table creation failed"

# Fix payments table structure
echo "Fixing payments table structure..."
PGPASSWORD=$DB_PASSWORD psql -h $DB_HOST -p $DB_PORT -U $DB_USERNAME -d $DB_DATABASE -f /var/www/database/sql/fix_payments_table.sql || echo "Payments table fix failed"

# Run migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction || echo "Migration failed, continuing..."

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
