FROM php:7.1.4-apache
MAINTAINER Eddie Peters edward.paul.peters@gmail.com

RUN sed -i 's/<VirtualHost *:80>/<VirtualHost *:*>/' /etc/apache2/sites-enabled/000-default.conf

RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf

RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

COPY . /var/www/
