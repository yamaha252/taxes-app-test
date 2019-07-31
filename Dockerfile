FROM webdevops/php-nginx:alpine

WORKDIR /app

COPY composer.json .
COPY composer.lock .

RUN composer install

COPY . .

COPY docker/config-local.php ./config-local.php
