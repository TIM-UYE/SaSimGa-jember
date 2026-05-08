FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files AND artisan file first
COPY composer.json composer.lock artisan ./

# Copy essential Laravel directories needed for package:discover
COPY composer.json composer.lock artisan ./
COPY bootstrap/ ./bootstrap/
COPY app/ ./app/
COPY config/ ./config/
COPY routes/ ./routes/


# Install dependencies (now artisan exists for package:discover)
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Copy the rest of the application
COPY . .

# Generate optimized autoload
RUN composer dump-autoload --optimize

# Create storage directories
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

USER www-data

EXPOSE 9000

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
