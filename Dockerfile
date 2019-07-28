FROM php:7.2-cli

RUN apt-get update && apt-get install -y locales git zip curl gnupg lsb-release && \
    docker-php-ext-install -j$(nproc) pdo_mysql

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet --install-dir=/usr/local/bin --filename=composer && \
    composer global config minimum-stability dev && \
    composer global config secure-http false && \
    composer global config repo.packagist composer https://packagist.org && \
    composer global require hirak/prestissimo

COPY . /usr/src/app
WORKDIR /usr/src/app

RUN composer install
