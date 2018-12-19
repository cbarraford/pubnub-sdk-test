FROM composer
MAINTAINER Chad Barraford

ADD composer.json /app/composer.json

RUN composer install --no-dev --prefer-dist

CMD ["php", "test.php"]
