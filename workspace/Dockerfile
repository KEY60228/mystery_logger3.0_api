FROM composer:1.10

RUN apk add --update --no-cache --repository http://alpine.gliderlabs.com/alpine/v3.12/main/ postgresql-client postgresql-dev git libjpeg-turbo-dev libpng-dev \
    && docker-php-ext-install pgsql pdo_pgsql \
    && docker-php-ext-configure gd --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

CMD [ "/bin/ash" ]
