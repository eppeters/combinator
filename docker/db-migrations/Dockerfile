FROM php:7.1.4-alpine
RUN apk update
RUN set -ex && \
    apk add postgresql-dev
RUN docker-php-ext-install pdo pdo_pgsql
