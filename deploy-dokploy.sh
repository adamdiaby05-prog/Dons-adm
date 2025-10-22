#!/bin/bash

echo "🚀 Déploiement sur Dokploy..."

# Générer la clé d'application
echo "🔑 Génération de la clé d'application..."
php artisan key:generate --force

# Installer les dépendances
echo "📦 Installation des dépendances..."
composer install --no-dev --optimize-autoloader

# Optimiser l'application
echo "⚡ Optimisation de l'application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Exécuter les migrations
echo "🗄️ Exécution des migrations..."
php artisan migrate --force

# Créer les liens symboliques
echo "🔗 Création des liens symboliques..."
php artisan storage:link

# Définir les permissions
echo "🔐 Définition des permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "✅ Déploiement terminé !"
