FROM bitnami/php-fpm:latest
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
