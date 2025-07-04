# Stage 1: instalar dependências com Composer
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-dev --no-autoloader

# Stage 2: aplicação Laravel com Apache e PHP 8.1
FROM php:8.1-apache

# Instala extensões necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpng-dev libonig-dev libxml2-dev zip git curl \
  && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl \
  && a2enmod rewrite

# Copia o código
COPY . /var/www/html

# Copia as dependências instaladas
COPY --from=vendor /app/vendor /var/www/html/vendor

# Ajusta permissões necessárias
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

WORKDIR /var/www/html

EXPOSE 80
