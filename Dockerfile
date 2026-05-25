# =============================================================================
# Dockerfile — miniproyecto (Laravel 12 + PHP 8.2 + Apache)
# -----------------------------------------------------------------------------
# Imagen lista para despliegue: instala extensiones PHP necesarias para Laravel
# y MySQL, instala dependencias en modo producción, configura permisos para
# storage / bootstrap/cache, habilita mod_rewrite y expone el puerto 80.
# =============================================================================

FROM php:8.2-apache

# Apt no interactivo durante el build
ENV DEBIAN_FRONTEND=noninteractive

# ---------------------------------------------------------------------------
# 1) Dependencias del sistema necesarias para compilar las extensiones PHP
# ---------------------------------------------------------------------------
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        curl \
        unzip \
        zip \
        ca-certificates \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        libicu-dev \
    && rm -rf /var/lib/apt/lists/*

# ---------------------------------------------------------------------------
# 2) Extensiones PHP requeridas por Laravel + driver de MySQL
#    pdo_mysql -> conexión a MySQL/MariaDB
#    mbstring, bcmath, intl, zip, xml, gd, exif -> Laravel/runtime
#    opcache -> rendimiento en producción
# ---------------------------------------------------------------------------
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo \
        pdo_mysql \
        mbstring \
        bcmath \
        intl \
        zip \
        xml \
        gd \
        exif \
        opcache

# ---------------------------------------------------------------------------
# 3) Composer 2 (copiado desde la imagen oficial — más rápido que descargarlo)
# ---------------------------------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---------------------------------------------------------------------------
# 4) Apache: mod_rewrite + DocumentRoot apuntando a /var/www/html/public
# ---------------------------------------------------------------------------
RUN a2enmod rewrite \
    && sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# ---------------------------------------------------------------------------
# 5) Directorio de trabajo y copia del código fuente del proyecto
# ---------------------------------------------------------------------------
WORKDIR /var/www/html

COPY . /var/www/html

# ---------------------------------------------------------------------------
# 6) Instalación de dependencias PHP en modo producción
#    --no-dev: omite dependencias de testing/desarrollo
#    --optimize-autoloader: genera mapa de clases optimizado (PSR-4)
# ---------------------------------------------------------------------------
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist \
    && composer clear-cache

# ---------------------------------------------------------------------------
# 7) Permisos para Laravel
#    storage/ y bootstrap/cache/ deben ser escribibles por Apache (www-data)
# ---------------------------------------------------------------------------
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ---------------------------------------------------------------------------
# 8) Puerto HTTP expuesto
# ---------------------------------------------------------------------------
EXPOSE 80

# Apache en primer plano (requerido por Docker)
CMD ["apache2-foreground"]
