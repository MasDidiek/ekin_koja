FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

RUN docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql \
    gd \
    zip

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

RUN mkdir -p application/session \
    && mkdir -p application/logs \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 application/session \
    && chmod -R 775 application/logs