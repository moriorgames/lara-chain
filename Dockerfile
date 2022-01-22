FROM chrisb9/php8-nginx-xdebug:latest

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable xdebug
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
RUN echo 'xdebug.mode=coverage' >> /usr/local/etc/php/php.ini

RUN mkdir -p /app

WORKDIR /app
