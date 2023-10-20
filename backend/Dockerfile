# Usar imagen base de PHP con Apache
FROM php:8.1-apache

# Instalar dependencias y extensiones con el usuario root
USER root
RUN apt-get update && apt-get install -y libpng-dev zip unzip
RUN docker-php-ext-install pdo pdo_mysql gd

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar el proyecto Laravel
COPY . /var/www/html

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Cambiar propietario de los directorios y permisos
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage

# Cambiar al usuario www-data
USER www-data
RUN composer install
