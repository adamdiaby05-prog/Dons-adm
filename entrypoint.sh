#!/bin/bash
set -e

# Vérifier si le fichier .env existe, sinon le créer à partir de .env.example
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

# Déterminer le type de connexion base de données (priorité à la variable d'environnement)
DB_CONNECTION_VALUE="${DB_CONNECTION:-}"
if [ -z "${DB_CONNECTION_VALUE}" ] && [ -f .env ]; then
    DB_CONNECTION_VALUE=$(grep -E '^DB_CONNECTION=' .env | cut -d= -f2 || true)
fi
DB_CONNECTION=${DB_CONNECTION_VALUE:-sqlite}

if [ "${DB_CONNECTION}" != "sqlite" ]; then
    DB_HOST=${DB_HOST:-db}
    DB_PORT=${DB_PORT:-5432}

    echo "Waiting for ${DB_CONNECTION} database at ${DB_HOST}:${DB_PORT}..."
    while ! nc -z "${DB_HOST}" "${DB_PORT}"; do
        sleep 1
    done
    echo "Database is ready!"
else
    echo "SQLite detected; no external database wait required."
    DB_DATABASE_VALUE="${DB_DATABASE:-}"
    if [ -z "${DB_DATABASE_VALUE}" ] && [ -f .env ]; then
        DB_DATABASE_VALUE=$(grep -E '^DB_DATABASE=' .env | cut -d= -f2- || true)
    fi
    SQLITE_PATH=${DB_DATABASE_VALUE:-database/database.sqlite}
    if [ ! -f "${SQLITE_PATH}" ]; then
        echo "Initializing SQLite database at ${SQLITE_PATH}..."
        mkdir -p "$(dirname "${SQLITE_PATH}")"
        touch "${SQLITE_PATH}"
    fi
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
