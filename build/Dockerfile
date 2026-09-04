FROM php:8.2-apache

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache: apuntar el DocumentRoot a /public y habilitar mod_rewrite
RUN sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Permitir que .htaccess de Laravel funcione (AllowOverride All)
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

WORKDIR /var/www

# Copiar solo composer.json/lock primero: esta capa se cachea
# y no se re-ejecuta salvo que estos archivos cambien.
COPY composer.json composer.lock ./

RUN composer config --global process-timeout 2000 \
    && composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

# Ahora sí, copiar el resto del código
COPY . /var/www

RUN composer dump-autoload --optimize

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 80
