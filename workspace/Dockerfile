FROM composer:1.10

RUN apk add --update --no-cache postgresql-client postgresql-dev git  \
  && docker-php-ext-install pgsql pdo_pgsql

CMD [ "/bin/ash" ]
