FROM php:7.2.1-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-install pdo_mysql

#  cat fichier conf
RUN adduser --gecos "" --disabled-password --no-create-home toto

# COPY config/www.conf dest