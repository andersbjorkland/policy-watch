FROM dunglas/frankenphp


RUN apt-get update && \
    apt-get install -y unzip  libpng-dev && \
    install-php-extensions mysqli intl gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG ENABLE_XDEBUG
RUN if [ "${ENABLE_XDEBUG}" = "true" ] ; then \
        pecl install xdebug-3.2.0 && \
        docker-php-ext-enable xdebug && \
        echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
        echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ; \
        echo "xdebug.idekey=caddy" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ; \
fi

RUN echo "memory_limit=-1" >> /usr/local/etc/php/conf.d/docker-php.ini
