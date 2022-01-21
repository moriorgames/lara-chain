FROM php:8-alpine3.15

RUN docker-php-ext-install pdo pdo_mysql

RUN mkdir -p /app

WORKDIR /app
