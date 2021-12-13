FROM php:7.4-fpm-alpine

ENV APP_DIR=/srv/app

RUN mkdir -p ${APP_DIR}

COPY src/ ${APP_DIR}

WORKDIR ${APP_DIR}

# Prevent that the directory is not writeable by the Web process
RUN chmod -R 777 ${APP_DIR}/web/assets
# Allow debug module working
RUN chmod -R 777 ${APP_DIR}/runtime

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

# Setup extensions (gd, pdo_mysql...) and terminal-supported libs
RUN apk add --no-cache \
        freetype \
        libjpeg-turbo \
        libpng \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
        # vim \
    && docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
        pdo \
        pdo_mysql \
        zip \
        bcmath \
    && docker-php-ext-enable gd \
    && apk del --no-cache \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
    && rm -rf /tmp/*

# # php.ini
# RUN mv "${PHP_INI_DIR}/php.ini-production" "${PHP_INI_DIR}/php.ini"

EXPOSE 9000

CMD ["php-fpm"]
