FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpng-dev libonig-dev libxml2-dev zip git curl \
  && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl \
  && a2enmod rewrite

WORKDIR /var/www/html

COPY . .

# Instala dependências diretamente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && composer install --no-interaction --prefer-dist --no-dev

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
