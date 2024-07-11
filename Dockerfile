# includes most required extensions
FROM php:8.1-apache

# install locales, gettext, zip, yaml
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    locales gettext zlib1g-dev libzip-dev libyaml-dev \
 && locale-gen en_GB.UTF-8 && locale-gen de_DE.UTF-8 && locale-gen pt_BR.UTF-8 && locale-gen hu_HU.UTF-8 \
 && apt-get --assume-yes autoremove \
 && rm -rf /var/lib/apt/lists/* \
 && pecl install yaml \
 && docker-php-ext-enable yaml \
 && docker-php-ext-install gettext zip

# install composer from its official Docker image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# copy application files, install PHP libraries and initialize
USER www-data
WORKDIR /var/www/html

# TODO: update version.ini

# TODO: chown www-data
COPY . .

RUN composer install --prefer-dist --no-dev \
 && composer clear-cache

RUN mkdir config metadata-qa \
 && echo dir=metadata-qa > configuration.cnf \
 && echo include=config/configuration.cnf >> configuration.cnf \
