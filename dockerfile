FROM php:8.3-fpm

# 1. Install dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# 2. Copy only composer files first (for better caching)
COPY composer.json composer.lock ./

# 3. Install dependencies without scripts first
RUN composer install --no-scripts --no-autoloader

# 4. Copy the rest of the application
COPY . .

# 5. Fix permissions BEFORE composer dump-autoload
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# 6. Finalize composer
RUN composer dump-autoload --optimize

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
