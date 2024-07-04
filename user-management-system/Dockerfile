# Utiliza la imagen oficial de PHP 8.1 con FPM
FROM php:8.1.12-fpm

# Instala dependencias y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip

# Instala Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configura el servidor web Nginx
COPY ./nginx.conf /etc/nginx/sites-available/default

# Copia la aplicación Laravel al contenedor
COPY . /var/www/html

# Establece permisos adecuados para el directorio de Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Instala las dependencias de Composer
RUN composer install --optimize-autoloader

# Ajusta configuración de PHP
RUN echo "upload_max_filesize = 50M\npost_max_size = 50M" > /usr/local/etc/php/conf.d/uploads.ini

# Script de inicio personalizado
COPY ./start-container.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

# Exponer el puerto 80 para el servidor web Nginx
EXPOSE 80

# Comando para iniciar PHP-FPM y Nginx
CMD /usr/local/bin/start-container && service nginx start && php-fpm