# ---------- Base PHP Image ----------
FROM php:8.3-fpm AS base

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpq-dev libonig-dev libzip-dev

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www


# ---------- Development Stage ----------
FROM base AS development

COPY . .

RUN composer install

RUN chown -R www-data:www-data /var/www

CMD ["php-fpm"]


# ---------- Production Stage (optional) ----------
FROM base AS production

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www

CMD ["php-fpm"]