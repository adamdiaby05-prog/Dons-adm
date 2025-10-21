# Utiliser une image PHP-FPM 8.2 officielle comme base
FROM php:8.2-fpm-alpine

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les dépendances système nécessaires
RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    postgresql-dev \
    unzip \
    curl \
    git \
    bash \
    composer

# Configurer et installer les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    pdo \
    pdo_pgsql \
    pgsql \
    zip \
    bcmath \
    opcache \
    xml \
    ctype \
    iconv \
    intl \
    pdo_mysql \
    dom \
    filter \
    gd \
    hash \
    json \
    mbstring \
    session \
    simplexml \
    tokenizer \
    curl

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier le script d'entrée
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Définir l'utilisateur par défaut
RUN addgroup -g 1000 -S laravel && \
    adduser -u 1000 -S laravel -G laravel

# Changer le propriétaire des répertoires
RUN chown -R laravel:laravel /var/www/html

# Exécuter le script d'entrée
ENTRYPOINT ["entrypoint.sh"]

# Démarrer PHP-FPM
CMD ["php-fpm"]