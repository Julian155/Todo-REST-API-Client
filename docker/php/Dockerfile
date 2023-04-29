FROM php:8.0.28-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    && docker-php-ext-install \
        mysqli \
        pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

COPY ../ /var/www/php
WORKDIR /var/www/php/


