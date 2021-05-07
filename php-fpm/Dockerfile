FROM php:7.4-fpm-alpine3.12

RUN apk add --update --no-cache --repository http://alpine.gliderlabs.com/alpine/v3.12/main/ postgresql-dev oniguruma-dev libjpeg-turbo-dev libpng-dev \ 
    && docker-php-ext-install mbstring pgsql pdo_pgsql exif \
    && docker-php-ext-configure gd --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    # && yes "" | pecl install xdebug \
    # && docker-php-ext-enable xdebug \
    && adduser -S nginx \
    && addgroup nginx \
    && mkdir -p /var/lib/php/session/ /var/run/php-fpm/ \
    && chown nginx:nginx /var/lib/php/session \
    && chown nginx:nginx /var/run/php-fpm

# for blackfire
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
&& curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/amd64/$version \
&& mkdir -p /tmp/blackfire \
&& tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
&& mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get ('extension_dir');")/blackfire.so \
&& printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
&& rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

CMD [ "php-fpm" ]
