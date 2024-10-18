#immagine PHP Apache
FROM php:8.3-apache

# Installa le estensioni PDO e Mysql
RUN apt-get update \
 && apt-get install -y git zlib1g-dev \
 && docker-php-ext-install pdo pdo_mysql
# Copio il file della mia appplicazione nella directory del server
COPY /src/index.php /var/www/html

# imposto i permessi dei file copiati
RUN chown -R www-data:www-data /var/www/html
# Espongo la Porta 80
EXPOSE 80
# Abilita il modulo Apache di rewrite
RUN a2enmod rewrite

