#immagine PHP Apache
FROM php:8.3-apache

# Installa le estensioni PDO e Mysql
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    graphviz \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql mysqli zip sockets \
    && docker-php-source delete \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copio il file della mia appplicazione nella directory del server
COPY /src/index.php /var/www/html/index.php

# imposto i permessi dei file copiati
RUN chown -R www-data:www-data /var/www/html
# Espongo la Porta 80
EXPOSE 80
# Abilita il modulo Apache di rewrite
RUN a2enmod rewrite

