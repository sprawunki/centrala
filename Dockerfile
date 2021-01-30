FROM php:7.3-fpm-alpine

COPY --from=composer:1 /usr/bin/composer /usr/bin/composer
COPY composer.json /var/www/html/composer.json

WORKDIR /var/www/html
RUN composer install --no-progress --no-dev

COPY app app
COPY bootstrap bootstrap
COPY public public
