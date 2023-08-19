FROM php:8.1-fpm

RUN rm -rf /var/lib/apt/lists/* \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
    git \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-configure \
    zip \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g yarn

RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && mkdir /var/www/.composer \
    && chown www-data:www-data /var/www/.composer \
    && mkdir /var/www/.yarn \
    && mkdir /var/www/.cache \
    && touch /var/www/.yarnrc \
    && chown www-data:www-data /var/www/.yarn \
    && chown www-data:www-data /var/www/.yarnrc \
    && chown www-data:www-data /var/www/.cache \
    && chmod -R 775 /var/www/.yarn \
    && chmod -R 775 /var/www/.yarnrc \
    && chmod -R 775 /var/www/.cache

RUN usermod -u 1000 www-data

USER 1000

WORKDIR /var/www/src

CMD ["php-fpm"]
