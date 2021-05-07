FROM nginx:1.19-alpine

WORKDIR /var/www/mystery_logger

COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY prod/nginx/laravel.conf /etc/nginx/conf.d/default.conf
