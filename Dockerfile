FROM php:fpm-alpine

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/1b137f8bf6db3e79a38a5bc45324414a6b1f9df2/web/installer -O - -q | php --

COPY app /var/www/html/app
COPY public /var/www/html/public
COPY tests /var/www/html/tests
COPY composer.json /var/www/html/composer.json

WORKDIR /var/www/html
RUN php composer.phar install
