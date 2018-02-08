FROM php:7.2.1-apache
EXPOSE 8080:80
ADD DockerConfig/dockerFiles/app/kraken.conf /etc/apache2/sites-available/kraken.conf
ADD KrakenSecurity /var/www/KrakenSecurity
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_VERSION 1.6.2
RUN apt-get update \
    && apt-get install -y git libmcrypt-dev libxml2-dev zlib1g-dev \
    && docker-php-ext-install \
        mbstring \
        pdo_mysql \
        bcmath \
        xml \
        zip \
    && docker-php-source delete \
    && a2ensite kraken \
    && a2dissite 000-default
RUN apt-get update -y && apt-get install -y libpng-dev
RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN cd /var/www/KrakenSecurity \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && php composer.phar install \
    && php composer.phar update
RUN cd /var/www/KrakenSecurity && chmod 777 -R storage
