FROM webdevops/php-nginx:alpine

ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz

RUN chmod 777 /tmp

WORKDIR /app

COPY composer.json .
COPY composer.lock .

RUN composer install

COPY . .

COPY docker/config-local.php ./config-local.php
COPY docker/startup.sh /entrypoint.d/startup.sh
COPY docker/nginx/location-root.conf /opt/docker/etc/nginx/vhost.common.d/10-location-root.conf
COPY docker/nginx/location-php.conf /opt/docker/etc/nginx/vhost.common.d/10-php.conf
