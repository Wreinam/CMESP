FROM php:8.1-apache

# Instala extensões necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpng-dev libonig-dev libxml2-dev zip git curl \
  && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl \
  && a2enmod rewrite

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto Laravel
COPY . .

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala dependências do Laravel
RUN composer install --no-interaction --prefer-dist --no-dev

# Cria o arquivo .env a partir do exemplo, se não existir
RUN cp .env.example .env

# Gera a chave da aplicação
RUN php artisan key:generate

# Ajusta permissões
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

