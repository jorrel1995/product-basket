ARG PHP_VERSION
FROM php:$PHP_VERSION-fpm

ARG NODE_VERSION

RUN apt -y update && apt -y upgrade

# added due to OGL requiring mysql client
RUN apt-get install -y default-mysql-client

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

RUN apt-get install -y libzip-dev zip \
  && docker-php-ext-install zip

RUN apt-get install libsodium-dev -y \
  && docker-php-ext-install sodium

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev && \
  docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ --with-webp && \
  docker-php-ext-install gd

RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

RUN apt-get install -y libicu-dev \
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl \
  && docker-php-ext-enable intl

RUN docker-php-ext-install opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

COPY ./zzz.ini /usr/local/etc/php/conf.d

# RUN curl -L "https://github.com/elastic/apm-agent-php/releases/download/v1.14.1/apm-agent-php_1.14.1_amd64.deb" > /tmp/apm-agent-php.deb && \
#   dpkg -i /tmp/apm-agent-php.deb && \
#   rm /tmp/apm-agent-php.deb

RUN curl -sL https://deb.nodesource.com/setup_$NODE_VERSION.x -o /tmp/nodesource_setup.sh

RUN bash /tmp/nodesource_setup.sh

RUN apt install -y nodejs

RUN echo "upload_max_filesize = 64M" >> /usr/local/etc/php/conf.d/zzz.ini