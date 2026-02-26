# For api container
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    curl \
    git \
    && docker-php-ext-install pdo_pgsql zip

# Install Swoole for Octane
RUN pecl install swoole \
    && docker-php-ext-enable swoole

# Install Redis extension (for queue)
RUN pecl install redis \
    && docker-php-ext-enable redis

WORKDIR /var/www

COPY . .

# Install Composer dependencies
RUN composer install --no-interaction --prefer-dist

CMD ["php-fpm"]