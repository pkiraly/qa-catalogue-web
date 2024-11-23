# includes most required extensions
FROM php:8.1-apache

# install locales, gettext, zip, yaml
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    locales gettext zlib1g-dev libzip-dev libyaml-dev nano libicu-dev libicu72 icu-devtools unzip sqlite3 \
 && locale-gen en_GB.UTF-8 && locale-gen de_DE.UTF-8 && locale-gen pt_BR.UTF-8 && locale-gen hu_HU.UTF-8 \
 && echo "en_GB.UTF-8 UTF-8" >> /etc/locale.gen \
 && echo "de_DE.UTF-8 UTF-8" >> /etc/locale.gen \
 && echo "pt_BR.UTF-8 UTF-8" >> /etc/locale.gen \
 && echo "hu_HU.UTF-8 UTF-8" >> /etc/locale.gen \
 && locale-gen \
# && dpkg-reconfigure locales \
 && apt-get --assume-yes autoremove \
 && rm -rf /var/lib/apt/lists/* \
 && pecl install yaml \
 && docker-php-ext-configure intl \
 && docker-php-ext-install gettext zip intl \
 && docker-php-ext-enable yaml intl

# install composer from its official Docker image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# copy application files, install PHP libraries and initialize
USER www-data
WORKDIR /var/www/html

# TODO: update version.ini

# TODO: chown www-data
COPY . .

USER root
RUN chown www-data:www-data -R /var/www/html/locale
USER www-data

RUN composer install --prefer-dist --no-dev \
 && composer clear-cache \
 && composer run translate
# && service apache2 restart

RUN mkdir config metadata-qa \
 && echo dir=metadata-qa > configuration.cnf \
 && echo include=config/configuration.cnf >> configuration.cnf

# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
