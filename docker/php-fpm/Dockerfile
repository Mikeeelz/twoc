FROM php:8.0-fpm-alpine AS site

RUN apk add --no-cache \
    bash \
    git \
    $PHPIZE_DEPS \
    icu-dev \
    libxml2-dev \
    freetype-dev \
    libzip-dev \
    make \
    curl

RUN docker-php-ext-install mysqli \
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-install intl \
  && docker-php-ext-install soap \
  && docker-php-ext-install zip \
  && docker-php-ext-install exif \
  && docker-php-ext-install opcache

COPY php-fpm.ini $PHP_INI_DIR/conf.d/
COPY php-fpm.ini $PHP_INI_DIR/conf.d/cli/conf.d/

COPY php-fpm.pool.conf /usr/local/etc/php-fpm.d/

COPY xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

RUN pecl install xdebug-3.0.4; \
    docker-php-ext-enable xdebug;

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-source delete

WORKDIR /application

CMD ["php-fpm", "-F"]

EXPOSE 9001
