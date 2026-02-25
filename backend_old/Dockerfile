FROM php:8.3-cli-alpine AS base

RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    postgresql-dev \
    redis \
    supervisor \
    unzip \
    git

RUN docker-php-ext-configure gd --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc) \
        bcmath \
        gd \
        pdo \
        pdo_pgsql \
        pgsql \
        pcntl \
        zip \
        opcache

RUN pecl install swoole && \
    docker-php-ext-enable swoole

RUN pecl install redis && \
    docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

FROM base AS dependencies
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --optimize-autoloader

COPY . .
RUN composer dump-autoload --optimize

FROM base AS development
ENV APP_ENV=local
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .
RUN composer install && \
    chown -R www-data:www-data storage bootstrap/cache
EXPOSE 8000
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000", "--watch"]

FROM base AS production
ENV APP_ENV=production
COPY --from=dependencies /var/www/vendor ./vendor
COPY . .
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000"]