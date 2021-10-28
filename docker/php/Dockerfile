FROM php:8.0-fpm

RUN docker-php-ext-install pdo_mysql

RUN apt-get update \
        && apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-configure zip\
  && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
