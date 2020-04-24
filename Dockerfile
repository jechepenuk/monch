FROM php:7.2-apache

RUN apt-get update && apt-get install -y

RUN docker-php-ext-install mysqli pdo_mysql

RUN mkdir /app \
 && mkdir /app/php-mysql \
 && mkdir /app/php-mysql/www

COPY www/ /app/php-mysql/www/

RUN cp -r /app/php-mysql/www/* /var/www/html/.