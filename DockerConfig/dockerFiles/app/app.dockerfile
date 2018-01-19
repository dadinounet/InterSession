FROM php:7.2.1-apache
EXPOSE 8080:80
ADD kraken.conf /etc/apache2/sites-available/kraken.conf
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_VERSION 1.6.2
RUN apt-get update \
    && apt-get install -y git \
    && docker-php-ext-install \
        mbstring \
        pdo_mysql \
    && docker-php-source delete \
    && a2ensite kraken \
    && a2dissite 000-default

