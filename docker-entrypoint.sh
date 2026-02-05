#!/bin/bash
set -e

# Ensure storage directory structure exists
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs

# Fix permissions - DISABLED completely to prevent Gateway Timeout
# chown -R www-data:www-data /var/www/html/storage
# chmod -R 775 /var/www/html/storage
# chown -R www-data:www-data /var/www/html/storage/framework
# chown -R www-data:www-data /var/www/html/storage/logs
# chown -R www-data:www-data /var/www/html/storage/app/public

# Create storage symlink
php artisan storage:link || true

# Clear caches to be safe
php artisan config:clear
php artisan cache:clear

# Execute the passed command (supervisord)
exec "$@"
