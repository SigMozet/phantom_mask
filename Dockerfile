FROM composer:1.8
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /source
COPY . .
RUN composer install
CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]
