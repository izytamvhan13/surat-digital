FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install \
        gd \
        zip \
        pdo \
        pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Permission dulu
RUN chmod -R 775 storage bootstrap/cache

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Clear & cache config
RUN php artisan config:clear || true
RUN php artisan config:cache || true

# Railway uses PORT
CMD php -S 0.0.0.0:${PORT:-8080} -t public
