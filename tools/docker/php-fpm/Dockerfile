FROM php:7.2-fpm
WORKDIR "/application"

RUN docker-php-ext-install -j$(nproc) mysqli
RUN docker-php-ext-install -j$(nproc) pdo
RUN docker-php-ext-install -j$(nproc) pdo_mysql

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.2-mysql \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# install dependencies
#RUN apt-get update -y && apt-get install lftp wget zip -y

# composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Install xdebug
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# Install composer
#RUN apt-get update && \
#    apt-get install -y --no-install-recommends git zip
#RUN curl --silent --show-error https://getcomposer.org/installer | php

#RUN ./application/docker/php-fpm/install_composer.sh
#RUN cd "/application" \
#    && curl --url "https://getcomposer.org/installer" > "/application/composer-setup.php" \
#    && php ./composer-setup.php \
#    && mv composer /usr/local/bin/composer \
#    && rm composer-setup.php