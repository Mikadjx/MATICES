FROM php:8.4-cli

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

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/symfony

# Créer les dossiers nécessaires
RUN mkdir -p var/cache var/log public/uploads/photos

EXPOSE 8000

# Démarrage
CMD composer install --no-interaction && \
    chmod -R 777 var/ public/uploads/ && \
    symfony server:start --no-tls --port=8000 --allow-http