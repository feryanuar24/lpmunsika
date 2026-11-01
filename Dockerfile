# Base PHP Image
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
    gd \
    intl \
    zip \
    opcache

WORKDIR /var/www/html

# Development Stage
FROM base AS development

ARG UID=1000
ARG GID=1000

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN { \
    echo 'upload_max_filesize = 25M'; \
    echo 'post_max_size = 32M'; \
    echo 'memory_limit = 256M'; \
    echo 'max_execution_time = 300'; \
    echo 'display_errors = On'; \
    echo 'display_startup_errors = On'; \
    echo 'error_reporting = E_ALL'; \
    echo 'opcache.enable = 1'; \
    echo 'opcache.validate_timestamps = 1'; \
    echo 'opcache.revalidate_freq = 0'; \
    } > /usr/local/etc/php/conf.d/custom.ini

RUN groupmod -o -g ${GID} www-data \
    && usermod -o -u ${UID} -g www-data www-data

USER www-data

EXPOSE 9000

CMD ["php-fpm"]

# Builder: Composer Dependencies (Production)
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

# Builder: Frontend Assets (Production)
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

ARG UID=1000
ARG GID=1000

RUN { \
    echo 'upload_max_filesize = 25M'; \
    echo 'post_max_size = 32M'; \
    echo 'memory_limit = 256M'; \
    echo 'max_execution_time = 60'; \
    echo 'display_errors = Off'; \
    echo 'log_errors = On'; \
    echo 'opcache.enable = 1'; \
    echo 'opcache.validate_timestamps = 0'; \
    echo 'opcache.max_accelerated_files = 10000'; \
    echo 'opcache.memory_consumption = 128'; \
    echo 'opcache.interned_strings_buffer = 16'; \
    } > /usr/local/etc/php/conf.d/custom.ini

RUN groupmod -o -g ${GID} www-data \
    && usermod -o -u ${UID} -g www-data www-data

COPY --chown=www-data:www-data . .

COPY --from=vendor --chown=www-data:www-data /var/www/html/vendor ./vendor

COPY --from=frontend --chown=www-data:www-data /var/www/html/public/build ./public/build

RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER www-data

EXPOSE 9000

CMD ["php-fpm"]
