FROM php:8.1.0-fpm
ENV TZ=America/Sao_Paulo
ARG PHP_IDE_CONFIG="serverName=Chain-Of-Responsibility-Pattern".
ARG XDEBUG_TRIGGER=docker
#ARG PHP_AUTOCONF="/usr/bin/autoconf"

ENV MT_USER mailtrap
ENV MT_PASSWD mailtrap
ENV MT_MAILBOX_LIMIT 51200000
ENV MT_MESSAGE_LIMIT 10240000

RUN apt-get update \
	&& apt-get -y install git curl libpng-dev libonig-dev libxml2-dev zip unzip libsqlite3-dev libsqlite3-tcl \
    wget dovecot-imapd telnet iputils-ping curl

RUN DEBIAN_FRONTEND=noninteractive apt-get install -y unzip libicu-dev postfix

RUN rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mbstring exif pcntl bcmath gd iconv
RUN apt-get update && apt-get -y install zlib1g g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_sqlite \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN pecl install apcu xdebug && docker-php-ext-enable xdebug

COPY /.setup/php/90-xdebug.ini "${PHP_INI_DIR}/conf.d"

RUN pear channel-update pear.php.net && \
    pear install mail_mime mail_mimedecode net_smtp net_idna2-beta Auth_SASL Horde_ManageSieve crypt_gpg

#RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini
RUN apt-get update && apt-get -y install sudo

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=root:www-data . /var/www/

#WORKDIR /var/
#COPY postfix/* /etc/postfix/
#COPY dovecot/conf.d/10-mail.conf /etc/dovecot/conf.d/10-mail.conf

EXPOSE 2525 80

WORKDIR /var/www/

RUN chown www-data:root . -R \
    && chown -R www-data:root /var/www/src/Infra/Database/ \
    && chmod -R a+rw /var/www/src/Infra/Database/