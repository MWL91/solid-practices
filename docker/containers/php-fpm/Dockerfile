FROM devilbox/php-fpm:7.4-base

# Update package lists and install necessary packages including git
RUN apt-get update && \
        apt-get install -y zip git && \
        docker-php-ext-install pdo_mysql

# Verify git installation
RUN git --version

# Install composer
RUN curl --silent --show-error https://getcomposer.org/composer.phar > composer.phar \
    && mv composer.phar /usr/bin/composer
RUN chmod +x /usr/bin/composer

EXPOSE 9000
CMD ["php-fpm", "-F"]
