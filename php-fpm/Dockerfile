FROM php:7.4-fpm-alpine3.12

RUN apk add --update --no-cache postgresql-dev oniguruma-dev \ 
  && docker-php-ext-install mbstring pgsql pdo_pgsql exif \
  # && yes "" | pecl install xdebug \
  # && docker-php-ext-enable xdebug \
  && adduser -S nginx \
  && addgroup nginx \
  && mkdir -p /var/lib/php/session/ /var/run/php-fpm/ \
  && chown nginx:nginx /var/lib/php/session \
  && chown nginx:nginx /var/run/php-fpm

CMD [ "php-fpm" ]
