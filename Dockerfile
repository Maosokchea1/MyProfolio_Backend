FROM php:8.4-apache

# Install essential system dependencies & composer
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Point Apache DocumentRoot to Laravel's public directory
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Add Directory permissions to Apache config
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Expose port 8080 (Render requirement)
ENV PORT=8080
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Install PHP dependencies via composer
RUN composer install --no-dev --optimize-autoloader

# Setup Laravel .env, create sqlite database file, and set permissions
RUN cp .env.example .env \
    && mkdir -p database \
    && touch database/database.sqlite \
    && php artisan key:generate \
    && chmod -R 777 storage database bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/database /var/www/html/bootstrap/cache

# Copy and give execute permission to start script
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Start using script
CMD ["/usr/local/bin/start.sh"]