FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libicu-dev \
    g++ \
    libssl-dev \
    curl \
    apt-utils \
    zip \
    libzip-dev \
    gnupg2  \
    lsb-release \
    wget \
    dos2unix \
    cmake

# Memcached
RUN apt-get update && apt-get install -y libmemcached11 libmemcachedutil2 libmemcached-dev libz-dev git
RUN pecl install memcached && docker-php-ext-enable memcached

# Local time
ENV TZ=Europe/Madrid
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "Europe/Madrid"\n' > /usr/local/etc/php/conf.d/tzone.ini

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY docker/php-fpm/conf/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php-fpm/entrypoint.sh /usr/local/bin/entrypoint

COPY . ./

RUN dos2unix /usr/local/bin/entrypoint

RUN chmod +x /usr/local/bin/entrypoint

WORKDIR /app

ENTRYPOINT [ "entrypoint" ]

CMD [ "php-fpm" ]