# Start with an official PHP image as the base image
FROM php:8.3-fpm

# Set environment variables (these can be overridden in docker-compose.yml)
ARG WWWGROUP=1000
ARG WWWUSER=1000  # You may want to set a default user ID if not passed

# Create a group and user with specific IDs
RUN groupadd --force -g ${WWWGROUP} sail && \
    useradd --force -u ${WWWUSER} --gid ${WWWGROUP} --create-home sail

# Install dependencies required for PHP extensions and Nginx (common for Laravel)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    git \
    curl \
    unzip \
    libmysqlclient-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www/html

# Copy application files from the host machine to the container
COPY . .

# Set proper permissions for the Laravel application (ensure the www user can access files)
RUN chown -R ${WWWUSER}:${WWWGROUP} /var/www/html

# Expose ports (for Nginx and application)
EXPOSE 80 5173

# Set environment variables required for Xdebug and Laravel Sail
ENV LARAVEL_SAIL=1
ENV XDEBUG_MODE=off
ENV XDEBUG_CONFIG="client_host=host.docker.internal"
ENV IGNITION_LOCAL_SITES_PATH=${PWD}

# Start PHP-FPM server to serve Laravel
CMD ["php-fpm"]
