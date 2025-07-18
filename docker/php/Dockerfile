FROM php:8.3-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    gnupg g++ procps openssl git unzip zlib1g-dev libzip-dev \
    libfreetype6-dev libpng-dev libjpeg-dev libicu-dev libonig-dev libxslt1-dev acl \
 && docker-php-ext-configure gd --with-jpeg --with-freetype \
 && docker-php-ext-install mysqli pdo pdo_mysql zip xsl gd intl opcache exif mbstring \
 && docker-php-ext-enable pdo_mysql \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN ["php","-v"]