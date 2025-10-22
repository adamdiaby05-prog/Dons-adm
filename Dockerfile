# Utiliser une image PHP-FPM 8.2 officielle comme base
FROM php:8.2-fpm-alpine

# Définir le répertoire de travail
WORKDIR /var/www/html

## ÉTAPE 1 : Installation des dépendances système
# Mettre à jour et installer les dépendances système nécessaires
RUN apk update && apk add --no-cache \
    # Dépendances runtime (à garder)
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    libxml2 \
    postgresql-libs \
    icu-libs \
    oniguruma \
    libcurl \
    bash \
    && apk add --no-cache --virtual .build-deps \
    # Dépendances de compilation (à supprimer après)
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libxml2-dev \
    postgresql-dev \
    unzip \
    curl-dev \
    git \
    icu-dev \
    oniguruma-dev \
    autoconf \
    g++ \
    make

## ÉTAPE 2 : Configuration et installation des extensions PHP
# Configurer GD avec support FreeType et JPEG
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Installer les extensions PHP en une seule commande
RUN docker-php-ext-install -j$(nproc) \
    gd \
    pdo \
    pdo_pgsql \
    pgsql \
    pdo_mysql \
    zip \
    bcmath \
    opcache \
    xml \
    intl \
    mbstring \
    exif \
    pcntl

# Configuration d'OPcache pour la production
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

# Configuration PHP pour Laravel
RUN { \
    echo 'upload_max_filesize=50M'; \
    echo 'post_max_size=50M'; \
    echo 'memory_limit=256M'; \
    echo 'max_execution_time=300'; \
    } > /usr/local/etc/php/conf.d/laravel.ini

# Nettoyage : Supprimer les dépendances de développement
RUN apk del --no-cache .build-deps

## ÉTAPE 3 : Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

## ÉTAPE 4 : Configuration utilisateur et permissions
# Créer l'utilisateur laravel
RUN addgroup -g 1000 -S laravel && \
    adduser -u 1000 -S laravel -G laravel

# Copier les fichiers du projet (à adapter selon votre structure)
COPY --chown=laravel:laravel . /var/www/html

# Installer les dépendances Composer (si composer.json existe)
USER laravel
RUN if [ -f composer.json ]; then \
    composer install --no-dev --optimize-autoloader --no-interaction --no-progress; \
    fi

# Créer les répertoires nécessaires avec les bonnes permissions
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache

# Revenir à root pour copier le script d'entrée
USER root

# Copier le script d'entrée
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# S'assurer que les répertoires ont les bonnes permissions
RUN chown -R laravel:laravel \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Définir l'utilisateur pour l'exécution
USER laravel

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Point d'entrée
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Commande par défaut
CMD ["php-fpm"]