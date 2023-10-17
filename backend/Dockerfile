FROM php:8.1-fpm

# Instalar dependencias y extensiones
RUN apt-get update && apt-get install -y libpng-dev zip unzip
RUN docker-php-ext-install pdo pdo_mysql gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar el proyecto Laravel
COPY . /var/www

# Instalar dependencias de Laravel
RUN composer install

# Copiar y establecer el script de entrada
COPY permissions.sh /permissions.sh
RUN chmod +x /permissions.sh
ENTRYPOINT ["/permissions.sh"]
