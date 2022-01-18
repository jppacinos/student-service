FROM php:7.4-fpm-alpine

RUN apk update && apk add --no-cache  git zip \
    # Docker php ext
    && docker-php-ext-install pdo_mysql mysqli

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.* /var/www/html/
RUN composer install --no-autoloader --no-scripts --prefer-dist

COPY . /var/www/html/
RUN composer dump-autoload \
    && composer clear-cache \
    && chown -R www-data:www-data storage bootstrap

WORKDIR /var/www/html/

EXPOSE 9000
