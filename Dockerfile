FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsodium-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (per 6ammart prerequisites)
# Note: ctype, tokenizer, xml, json, openssl are already compiled into php:8.2-fpm
# We install: pdo_mysql, mysqli, mbstring, bcmath, gd, zip, opcache, exif, pcntl, fileinfo, sodium
RUN docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd zip opcache fileinfo sodium

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create .env file if it doesn't exist
RUN cp -n .env.production .env || true

# Set permissions for Laravel and installation requirements
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/public \
    && chmod 666 /var/www/html/.env \
    && chmod 666 /var/www/html/config/system-addons.php \
    && chmod 666 /var/www/html/app/Providers/RouteServiceProvider.php

# Copy nginx config
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Copy supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Create storage symlink (skip cache since .env needs setup)
RUN php artisan storage:link || true

# Expose port
EXPOSE 80

# Start supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
