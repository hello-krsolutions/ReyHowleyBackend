FROM php:8.2-fpm

# Rebuild trigger: 2026-02-05 - Force rebuild to install GD extension

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsodium-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (per 6ammart prerequisites)
# Note: ctype, tokenizer, xml, json, openssl are already compiled into php:8.2-fpm
# We install: pdo_mysql, mysqli, mbstring, bcmath, gd (with freetype), zip, opcache, exif, pcntl, fileinfo, sodium
# Configure GD with FreeType and WebP support (required for captcha and optimization)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd zip opcache fileinfo sodium

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create .env from production config (force overwrite)
RUN cp -f .env.production .env || true

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

# Create public/public symlink for asset()helper compatibility
# The 6ammart views use asset('public/...') but Nginx root is already /public
RUN cd /var/www/html/public && ln -sf . public

# Expose port
EXPOSE 80

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Start supervisor
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
