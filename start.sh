#!/bin/sh

# Ensure .env exists
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
    else
        touch .env
    fi
    php artisan key:generate
fi

# Make sure database directory exists and touch sqlite file with absolute path
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite

# Force SQLite configuration and file drivers in .env
sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
sed -i 's|^DB_DATABASE=.*|DB_DATABASE=/var/www/html/database/database.sqlite|' .env
sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env
sed -i 's/^CACHE_STORE=.*/CACHE_STORE=file/' .env

# Set proper permissions
chmod -R 777 storage database bootstrap/cache

# Clear cache and run migrations
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan migrate --force || true

apache2-foreground