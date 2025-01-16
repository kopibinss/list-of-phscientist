# Base image for PHP 8.3 with FPM
FROM php:8.3-fpm

# Arguments from docker-compose
ARG WWWGROUP
ARG WWWUSER

# Set environment variables
ENV DEBIAN_FRONTEND noninteractive

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    zip \
    bash && \
    docker-php-ext-install pdo_mysql mbstring zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Fix permissions
RUN groupadd -g "$WWWGROUP" sail && \
    useradd -u "$WWWUSER" -g sail -m sail && \
    chown -R sail:sail /var/www/html

# Switch to the sail user
USER sail

# Expose the application port
EXPOSE 80

# Run PHP-FPM by default
CMD ["php-fpm"]
