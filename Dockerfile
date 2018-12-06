FROM fsilva/php:7.2

ENV WEBROOT public
ENV USE_XDEBUG no

WORKDIR /var/www/app

COPY bin bin
COPY config config
COPY public public
COPY src src
COPY vendor vendor
COPY .env .env
COPY composer.json composer.json

RUN chown www-data:root config/*.key
RUN chmod 0660 config/*.key

RUN mkdir -p /var/www/app/var; chmod -R 0777 /var/www/app/var