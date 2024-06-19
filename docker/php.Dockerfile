FROM php:8.3.8-fpm

RUN apt update
RUN apt install -y libzip-dev
RUN docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2.7.7 /usr/bin/composer /usr/local/bin/composer

USER nobody
WORKDIR /app

COPY composer.json composer.lock ./
RUN php /usr/local/bin/composer install --prefer-dist

COPY docker/.env .env
COPY src src
COPY public public
