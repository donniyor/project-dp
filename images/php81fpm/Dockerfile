FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y curl git zip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql sockets zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1002 www-data && groupmod -g 1002 www-data

USER www-data

WORKDIR /var/www

ENTRYPOINT ["php-fpm"]
