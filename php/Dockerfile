FROM php:7.2-fpm-stretch

COPY ./php7.2/php.ini /usr/local/etc/php/

RUN mkdir -p /var/log/php_log

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libmcrypt-dev \
    libsqlite3-dev \
    vim \

    # iconv
    && docker-php-ext-install -j$(nproc) iconv \

    # mcrypt
    && pecl install mcrypt-1.0.1 \
    && docker-php-ext-enable mcrypt \

    # redis
    && pecl install -o -f redis-4.3.0 \
    && docker-php-ext-enable redis\

    # pgsql
    && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql \

    # sqlite
    && docker-php-ext-install pdo_sqlite \

    && docker-php-ext-install mbstring \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \

    # xdebug
    && pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=on" >> /usr/local/etc/php/conf.d/xdebug.ini

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*