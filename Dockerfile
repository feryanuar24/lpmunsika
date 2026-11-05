# Base: PHP Image
FROM php:8.5-fpm-alpine AS base

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk add --no-cache \
    shadow \
    git \
    curl \
    unzip \
    && install-php-extensions \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    redis \
    gd \
    intl \
    zip \
    opcache

WORKDIR /var/www/html

# Development Stage
FROM base AS development

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/development.ini /usr/local/etc/php/conf.d/custom.ini

RUN groupmod -o -g 1000 www-data \
    && usermod -o -u 1000 -g www-data www-data

USER www-data

EXPOSE 9000

CMD ["php-fpm"]

# Vendor: Composer Dependencies
FROM composer:latest AS vendor

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-scripts \
    --no-progress \
    --no-interaction \
    --optimize-autoloader

# Frontend: Node.js Build
FROM node:22-alpine AS frontend

WORKDIR /var/www/html

COPY package.json package-lock.json ./
RUN npm ci

COPY vite.config.js tailwind.config.js* ./
COPY resources/ resources/
COPY public/ public/

RUN npm run build

# Production Stage
FROM base AS production

COPY docker/php/production.ini /usr/local/etc/php/conf.d/custom.ini

RUN groupmod -o -g 1000 www-data \
    && usermod -o -u 1000 -g www-data www-data

COPY --chown=www-data:www-data . .

COPY --from=vendor --chown=www-data:www-data /var/www/html/vendor ./vendor

COPY --from=frontend --chown=www-data:www-data /var/www/html/public/build ./public/build

RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER www-data

EXPOSE 9000

CMD ["php-fpm"]
