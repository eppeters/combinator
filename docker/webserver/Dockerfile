FROM php:7.1.4-apache
MAINTAINER Eddie Peters edward.paul.peters@gmail.com

RUN apt-get -y update && \
	apt-get -y install libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql

# Apache configuration
RUN set -xe && \
				sed -i 's/<VirtualHost *:80>/<VirtualHost *:*>/' /etc/apache2/sites-enabled/000-default.conf && \
				echo 'Listen ${PORT}' > /etc/apache2/ports.conf && \
				cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

COPY . /var/www/
