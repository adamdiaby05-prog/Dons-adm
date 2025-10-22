# Dons ADM - Application de Collecte de Dons

Application Laravel pour la collecte de dons avec intégration FedaPay.

## 🚀 Installation

### Prérequis
- PHP 8.2+
- Composer
- PostgreSQL
- Node.js (optionnel)

### Configuration

1. **Cloner le repository**
```bash
git clone https://github.com/adamdiaby05-prog/Dons-adm.git
cd Dons-adm
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configuration de la base de données**
Modifier le fichier `.env` :
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=dons_db
DB_USERNAME=postgres
DB_PASSWORD=0000
```

5. **Configuration FedaPay**
Ajouter vos clés API dans le fichier `.env` :
```env
FEDAPAY_PUBLIC_KEY=votre_cle_publique
FEDAPAY_SECRET_KEY=votre_cle_secrete
FEDAPAY_ENVIRONMENT=live
FEDAPAY_BASE_URL=https://api.fedapay.com/v1
```

6. **Exécuter les migrations**
```bash
php artisan migrate
```

7. **Démarrer le serveur**
```bash
php artisan serve
```

## 🐳 Déploiement avec Docker

### Développement local
```bash
docker-compose up -d
```

### Production avec Dokploy
1. Configurer les variables d'environnement sur Dokploy
2. Déployer avec le fichier `dokploy.yml`

## 📱 Fonctionnalités

- ✅ Page d'accueil avec présentation du candidat
- ✅ Sélection du réseau de paiement (MTN, MOOV, Orange, Wave)
- ✅ Saisie du numéro de téléphone
- ✅ Saisie du montant du don
- ✅ Intégration FedaPay pour les paiements
- ✅ Enregistrement en base de données PostgreSQL
- ✅ Interface responsive et moderne

## 🔧 Configuration FedaPay

Pour utiliser FedaPay, vous devez :
1. Créer un compte sur [FedaPay](https://fedapay.com)
2. Obtenir vos clés API (publique et secrète)
3. Les ajouter dans le fichier `.env`

## 📄 Structure du projet

```
laravel-don/
├── app/
│   ├── Http/Controllers/
│   └── Models/
├── config/
├── database/migrations/
├── public/
│   ├── css/
│   └── images/
├── resources/views/
├── routes/
└── storage/
```

## 🚀 Déploiement

### Variables d'environnement requises

```env
APP_NAME="Dons ADM"
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=pgsql
DB_HOST=dons-database-nl3z8n
DB_PORT=5432
DB_DATABASE=Dons
DB_USERNAME=postgres
DB_PASSWORD=9zctibtytwmv640w
FEDAPAY_PUBLIC_KEY=votre_cle_publique
FEDAPAY_SECRET_KEY=votre_cle_secrete
FEDAPAY_ENVIRONMENT=live
FEDAPAY_BASE_URL=https://api.fedapay.com/v1
```

## 📞 Support

Pour toute question ou problème, contactez l'équipe de développement.

## 📝 Licence

Ce projet est sous licence MIT.