FROM php:8.3-fpm-alpine

ARG user=developer
ARG uid=1000

RUN apk update && apk add \
    curl \
    libpng-dev \
    libxml2-dev \
    php-gd \
    git \
    zip \
    unzip \
    shadow \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libxml2-dev \
    build-base \
    autoconf \
    libtool

RUN docker-php-ext-install pdo pdo_mysql pcntl exif \
    && apk --no-cache add nodejs npm

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN apk add \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

# Instalar y habilitar extensión de Redis
RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user

RUN mkdir -p /var/www && \
    chown -R $user:$user /var/www && \
    chmod -R 777 /var/www

RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www

COPY . .

ADD ./docker/docker-compose/php/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

USER $user

RUN composer install

RUN npm install

RUN npm run build

EXPOSE 9000
CMD ["php-fpm"]
