FROM php:7.4-fpm-alpine

RUN apk update && apk add bash && apk add curl

# INSTALL COMPOSER
RUN curl -s https://getcomposer.org/installer | php
RUN echo 'alias composer="php composer.phar"' >> ~/.bashrc

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html/users