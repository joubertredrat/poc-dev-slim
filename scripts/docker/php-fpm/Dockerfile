FROM php:7.1-fpm-alpine

MAINTAINER Joubert RedRat <eu@redrat.com.br>

RUN apk update && apk add sqlite && apk add socat && apk add patch

COPY . /var/www/html

RUN chown -Rf www-data:www-data /var/www/html

RUN rm -Rf /var/www/html/logs/*.log

USER www-data

RUN cd /var/www/html && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');"

RUN php /var/www/html/composer.phar install

RUN php /var/www/html/public/index.php db:database:drop

RUN php /var/www/html/public/index.php db:database:create

RUN php /var/www/html/public/index.php db:schema:create