FROM php:8.1.0-fpm

# Install Xdebug
RUN pecl install xdebug
#    && docker-php-ext-enable xdebug \
#    && echo "zend_extension=$(find $(php-config --extension-dir) -name xdebug.so)" \
#             > /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#RUN echo "zend_extension=$(find $(php-config --extension-dir) -name xdebug.so)" \
#             > /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install mysqli pdo pdo_mysql sockets
RUN docker-php-ext-enable pdo_mysql sockets

# Copy composer.lock and composer.json
#COPY ../../composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www/househub_monolith_mvp

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
#RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
#RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
#RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

#RUN pecl install xdebug
#RUN echo 'zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20160303/xdebug.so' | tee /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.mode=debug" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.start_with_request=yes" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_handler=dbgp" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_port=9000" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.client_host=host.docker.internal" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_connect_back=0" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.idekey=PHPSTORM" | tee -a /usr/local/etc/php/conf.d/xdebug.ini

# Copy existing application directory contents
#COPY . /var/www

# Copy existing application directory permissions
#COPY --chown=www:www . /var/www
COPY --chown=www:www househub_monolith_mvp /var/www/househub_monolith_mvp

COPY --chown=www:www deployment/configs/php.ini /usr/local/etc/php/php.ini

# Some configurations for PHPStan
RUN echo -e "\n# some instructions for export" >> ~/.bashrc
RUN echo -e "export PATH=$PATH:/var/www/househub_monolith_mvp/vendor/phpstan/phpstan/" >> ~/.bashrc
RUN export PATH=$PATH:/var/www/househub_monolith_mvp/vendor/phpstan/phpstan/

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]