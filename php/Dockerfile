FROM php:7.1-fpm


# COPY ./app /usr/src/myapp
# WORKDIR /usr/src/myapp
# CMD [ "php", "./index.php" ]

RUN apt-get update && apt-get install -y \
        # libfreetype6-dev \
        # libjpeg62-turbo-dev \
        # libpng-dev \
        libpq-dev \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && docker-php-ext-install -j$(nproc) pgsql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug 

# RUN apt-get update && apt-get install -y \
#         libfreetype6-dev \
#         libjpeg62-turbo-dev \
#         libmcrypt-dev \
#         libpng-dev \
#         libicu-dev \
#         libpq-dev \
#         libxpm-dev \
#         libvpx-dev \
#     && docker-php-ext-install -j$(nproc) pgsql pd0_pgsql\


# RUN apt-get update && apt-get install -y \
#         libfreetype6-dev \
#         libjpeg62-turbo-dev \
#         libmcrypt-dev \
#         libpng-dev \
#         libicu-dev \
#         libpq-dev \
#         libxpm-dev \
#         libvpx-dev \
#     && pecl install xdebug \
#     && docker-php-ext-enable xdebug \
#     && docker-php-ext-install -j$(nproc) mcrypt \
#     && docker-php-ext-install -j$(nproc) gd \
#     && docker-php-ext-install -j$(nproc) intl \
#     && docker-php-ext-install -j$(nproc) zip \
#     && docker-php-ext-install -j$(nproc) pgsql \
#     && docker-php-ext-install -j$(nproc) pdo_pgsql \
#     && docker-php-ext-install -j$(nproc) exif \
#     && docker-php-ext-configure gd \
#         --with-freetype-dir=/usr/include/ \
#         --with-jpeg-dir=/usr/include/ \
#         --with-xpm-dir=/usr/lib/x86_64-linux-gnu/ \
#         --with-vpx-dir=/usr/lib/x86_64-linux-gnu/ \