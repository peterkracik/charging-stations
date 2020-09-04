FROM registry.pk-dev.com/docker/nginx-php:php-7.4

RUN apk --update add --virtual \
    build-dependencies \
    build-base \
    openssl-dev \
    autoconf \
    freetype \
    # libpng \
    # libjpeg-turbo \
    # freetype-dev \
    # libpng-dev \
    # libjpeg-turbo-dev \
    # && docker-php-ext-configure gd --with-freetype --with-jpeg \
    # && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
    # && docker-php-ext-install -j${NPROC} gd \
    && apk del build-dependencies build-base openssl-dev autoconf \
    && rm -rf /var/cache/apk/* \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

ENV COMPOSER_ALLOW_SUPERUSER 1

COPY ./config/nginx_symfony.conf /etc/nginx/conf.d/
COPY ./config/php_php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./config/php_symfony.pool.conf /usr/local/etc/php/conf.d/symfony.pool.conf

WORKDIR /var/www
ADD ./app /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# load fixuteres
RUN bin/console doctrine:fixtures:load -q

# RUN mkdir -p /var/www/var/cache && \
#     mkdir -p /var/www/var/log && \
#     composer install --no-dev && \
#     bin/console assets:install && \
#     chmod -R 777 /var/www/var/
