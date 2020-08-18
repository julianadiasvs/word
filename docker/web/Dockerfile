FROM php:7.2-apache

MAINTAINER elton.ms@gmail.com

ARG PHALCON_VERSION=3.4.2
ARG PHALCON_EXT_PATH=php7/64bits

RUN apt-get update && apt-get install -y apt-utils libxml2-dev libpng-dev libcurl3-dev vim unzip \
	openssl libxslt-dev libjpeg-dev libfreetype6-dev

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd
RUN docker-php-ext-configure mysqli --with-mysqli=mysqlnd
RUN docker-php-ext-install ctype curl dom gd intl mbstring hash mysqli pdo pdo_mysql xml simplexml soap zip iconv bcmath xsl

#RUN set -xe && \
#        # Compile Phalcon
#        curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
#        tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
#        docker-php-ext-install -j $(getconf _NPROCESSORS_ONLN) ${PWD}/cphalcon-${PHALCON_VERSION}/build/${PHALCON_EXT_PATH} && \
#        # Remove all temp files
#        rm -r \
#        ${PWD}/v${PHALCON_VERSION}.tar.gz

# Enable Mod-Rewrite
RUN a2enmod rewrite

# Install Git
RUN set -xe && \
        apt-get update && \
        apt-get install git -y

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin \
        --filename=composer

# Install NodeJS
#RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
#RUN apt-get install -y nodejs

# Install Angular
#RUN npm install -g @angular/cli

# Install Lumen
#RUN composer global require "laravel/lumen-installer"

#Setando Timezone
ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY sites-available/ /etc/apache2/sites-available/
