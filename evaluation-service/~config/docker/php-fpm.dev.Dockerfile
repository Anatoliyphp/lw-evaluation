FROM php:7.4-fpm

RUN docker-php-ext-install pdo pdo_mysql

# these packages are required to install composer dependencies

RUN apt update && apt -y install git libzip-dev
RUN docker-php-ext-install zip