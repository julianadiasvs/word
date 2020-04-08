FROM php:7.2-apache

LABEL maintainer="MilesChou <github.com/MilesChou>, fizzka <github.com/fizzka>"

ARG PHALCON_VERSION=3.4.2
ARG PHALCON_EXT_PATH=php7/64bits

RUN set -xe && \
        # Compile Phalcon
        curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
        tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
        docker-php-ext-install -j $(getconf _NPROCESSORS_ONLN) ${PWD}/cphalcon-${PHALCON_VERSION}/build/${PHALCON_EXT_PATH} && \
        # Remove all temp files
        rm -r \
           ${PWD}/v${PHALCON_VERSION}.tar.gz

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd
RUN docker-php-ext-configure mysqli --with-mysqli=mysqlnd
RUN docker-php-ext-install ctype curl dom gd intl mbstring hash mysqli pdo pdo_mysql xml simplexml soap zip iconv bcmath xsl

# Install Git
RUN set -xe && \
        apt-get update && \
        apt-get install git -y

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin \
        --filename=composer

# Execute composer
WORKDIR "/var/www/html"
# RUN composer install
# RUN ls

# Enable Mod-Rewrite
RUN a2enmod rewrite


#           ${PWD}/cphalcon-${PHALCON_VERSION}

# COPY ${PWD}/cphalcon-${PHALCON_VERSION}/build/${PHALCON_EXT_PATH}/* /usr/local/bin/
