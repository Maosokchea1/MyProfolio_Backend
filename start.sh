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

# Make sure database directory exists and touch sqlite file
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite

# Force SQLite and drivers in .env
sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
sed -i 's|^DB_DATABASE=.*|DB_DATABASE=/var/www/html/database/database.sqlite|' .env
sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env
sed -i 's/^CACHE_STORE=.*/CACHE_STORE=file/' .env
sed -i 's|^APP_URL=.*|APP_URL=https://myprofolio-backend-sk.onrender.com|' .env

# Set proper permissions
chmod -R 777 storage database bootstrap/cache

# Clear ALL cached files
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Create storage symbolic link to make files publicly accessible
php artisan storage:link --force

# Run migration
php artisan migrate --force || true

# ==========================================
# FIX: Force fix Apache MPM conflict here
# ==========================================
rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.*
ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/
ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/

# Start Apache
exec apache2-foreground