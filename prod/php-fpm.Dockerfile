FROM composer:1.10 as builder

WORKDIR /var/app/
COPY src/ .
# RUN composer update --no-dev --no-scripts --optimize-autoloader  \
RUN composer update --no-scripts --optimize-autoloader \
    composer dump-autoload -o

# マルチステージビルド
FROM php:7.4-fpm-alpine3.12

WORKDIR /var/www/mystery_logger

RUN apk add --update --no-cache --repository http://alpine.gliderlabs.com/alpine/v3.12/main/ postgresql-dev oniguruma-dev libjpeg-turbo-dev libpng-dev \ 
    && docker-php-ext-install mbstring pgsql pdo_pgsql exif \
    && docker-php-ext-configure gd --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && adduser -S nginx \
    && addgroup nginx \
    && mkdir -p /var/lib/php/session/ /var/run/php-fpm/ \
    && chown nginx:nginx /var/lib/php/session \
    && chown nginx:nginx /var/run/php-fpm

COPY --from=builder /var/app .
COPY php-fpm/php.ini /usr/local/etc/php/php.ini
COPY php-fpm/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY php-fpm/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf

RUN chmod -R 777 /var/www/mystery_logger/storage \
    && chmod -R 777 /var/www/mystery_logger/bootstrap/cache \
    && cp .env.example .env \
    && php artisan key:generate \
    && php artisan route:cache

CMD [ "php-fpm" ]
