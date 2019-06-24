FROM techcto/alpine-php-fpm-7.2:latest

RUN mkdir -p /usr/local/bin
COPY ./docker/wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod a+rx /usr/local/bin/wait-for-it.sh

#Set Environment
ENV APP_DIR=/var/www/app \
    COMPOSER_CACHE_DIR=/var/cache/composer \
    COMPOSER_ALLOW_SUPERUSER=1

ENV PATH=${APP_DIR}/bin:${APP_DIR}/vendor/bin:${PATH}

WORKDIR ${APP_DIR}

RUN set -ex

ARG APP_ENV=dev
ENV APP_ENV ${APP_ENV}

ARG SOURCE_DIR=.

#Mail & License Check Requirements (JDK with NSS)
RUN apk add openjdk8 nss postfix rsyslog
    
#Install App
COPY docker/app/init.sh ./init.sh
COPY www ./www
COPY src ./src
COPY config ./config
COPY tests ./tests
COPY ui ./ui
COPY vendor ./vendor

#Configure Tmp & Session
RUN mkdir -p /var/lib/php/tmp \
    && mkdir -p ./tmp \
    && mkdir -p /var/lib/php/session \
    && chown -Rf www-data:www-data /var/lib/php/tmp ./tmp /var/lib/php/session \
    && chmod -Rf 777 /var/lib/php/tmp ./tmp /var/lib/php/session

COPY $SOURCE_DIR/composer.* ${APP_DIR}/
RUN if [ -f composer.json ] && [ ${APP_ENV} != "prod" ]; then \
    composer install --optimize-autoloader --no-dev ; fi
RUN if [ -f public/composer.json ] && [ ${APP_ENV} != "prod" ]; then \
    cd public \
    && composer install --optimize-autoloader --no-dev ; fi
RUN rm -rf ${COMPOSER_CACHE_DIR}/*

COPY docker/app/php.ini /usr/local/etc/php/php.ini
COPY docker/app/php-fpm.conf /usr/local/etc/php-fpm.conf

#Entrypoint
COPY ./docker/app/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod a+rx /docker-entrypoint.sh
ENTRYPOINT ["sh", "/docker-entrypoint.sh"]