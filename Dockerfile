FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Laravel config
COPY .docker/php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www
