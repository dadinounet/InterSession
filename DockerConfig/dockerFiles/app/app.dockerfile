FROM php:7.2.1-apache
EXPOSE 8080:80
ADD DockerConfig/dockerFiles/app/kraken.conf /etc/apache2/sites-available/kraken.conf
ADD KrakenSecurity /var/www/KrakenSecurity
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_VERSION 1.6.2
RUN apt-get update \
    && apt-get install -y git libmcrypt-dev libxml2-dev \
    && docker-php-ext-install \
        mbstring \
        pdo_mysql \
        bcmath \
        xml \
    && docker-php-source delete \
    && a2ensite kraken \
    && a2dissite 000-default
RUN cd /var/www/KrakenSecurity && chmod 777 -R storage
