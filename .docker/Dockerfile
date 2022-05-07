ARG PHP_VERSION
ARG PHP_VERSION_MAIN
FROM php:${PHP_VERSION}-apache
ARG PHP_VERSION_MAIN

RUN apt-get update \
    && apt-get install -y libz-dev libxml2-dev libmemcached-dev libmemcached11 libmemcachedutil2 build-essential libpng-dev \
    libfreetype6-dev libjpeg62-turbo-dev zip libzip-dev \
    && apt-get remove -y build-essential libmemcached-dev libz-dev \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /tmp/pear

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install pdo pdo_mysql mysqli gettext soap exif gd zip

RUN curl -fSL 'http://downloads3.ioncube.com/loader_downloads/ioncube_loaders_lin_x86-64.tar.gz' -o ioncube.tar.gz \
    && mkdir -p ioncube \
    && tar -xf ioncube.tar.gz -C ioncube --strip-components=1 \
    && rm ioncube.tar.gz \
    && mv ioncube/ioncube_loader_lin_${PHP_VERSION_MAIN}.so `php-config --extension-dir` \
    && rm -Rf ioncube.tar.gz ioncube \
    && docker-php-ext-enable ioncube_loader_lin_${PHP_VERSION_MAIN}


RUN pecl install xdebug  && docker-php-ext-enable xdebug

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN pecl install -o -f redis \
    && docker-php-ext-enable redis.so \
    && pecl clear-cache



