FROM php:8.4-fpm

# Installation des dépendances
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    zip \
    curl \
    libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql zip opcache intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/symfony

# Créer les dossiers nécessaires
RUN mkdir -p var/cache var/log public/uploads/photos

EXPOSE 9000

# Démarrage
CMD composer install --no-interaction --optimize-autoloader && \
    chown -R www-data:www-data var/ public/uploads/ && \
    php-fpm