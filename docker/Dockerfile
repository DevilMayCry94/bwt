# Use the official PHP 8.2 image as a base
FROM php:8.2-fpm

# Set the working directory in the container
WORKDIR /app

# Install required dependencies and Memcached extension
RUN apt-get update && apt-get install -y \
    libmemcached-dev \
    zlib1g-dev \
    libssl-dev \
    pkg-config

RUN yes '' | pecl install -f memcached-3.2.0 \
  && docker-php-ext-enable memcached

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN echo "xdebug.coverage_enable" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Copy the application code into the container
COPY . /app

# Install composer if needed
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Expose PHP-FPM default port
EXPOSE 9000
