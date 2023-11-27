FROM devilbox/php-fpm:7.4-base

RUN apt-get update && \
        apt-get install zip git -y \
        docker-php-ext-install pdo_mysql

# composer
RUN curl --silent --show-error https://getcomposer.org/composer.phar > composer.phar \
    && mv composer.phar /usr/bin/composer
RUN chmod +x /usr/bin/composer

EXPOSE 9000
CMD ["php-fpm", "-F"]