#!/bin/bash

# Attendre que la base de données soit disponible
echo "Waiting for database to be ready..."
while ! nc -z db 5432; do
  sleep 1
done
echo "Database is ready!"

# Vérifier si le fichier .env existe, sinon le créer à partir de .env.example
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

# Installer les dépendances Composer si vendor n'existe pas
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Générer la clé de l'application si elle n'existe pas
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating application key..."
    php artisan key:generate
fi

# Exécuter les migrations
echo "Running database migrations..."
php artisan migrate --force

# Créer le lien symbolique pour le stockage
if [ ! -L "public/storage" ]; then
    echo "Creating storage symbolic link..."
    php artisan storage:link
fi

# Donner les permissions appropriées
echo "Setting permissions..."
chown -R laravel:laravel /var/www/html
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

# Exécuter la commande passée en argument
exec "$@"