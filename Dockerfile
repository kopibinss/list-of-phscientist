# Use official PHP image with FPM
FROM php:8.2-fpm-alpine

# Install dependencies and cleanup in one RUN command to minimize layers
RUN apk update && apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    libfreetype6-dev \
    bash \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && rm -rf /var/cache/apk/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy the application code
COPY . .

# Set environment variables
ENV APP_NAME=PHScientists \
    APP_ENV=local \
    APP_KEY=base64:v9AbUhNzqrbFIzuYnJyYV6I2cXc6TBkzizKsPzMGumw= \
    APP_DEBUG=true \
    APP_TIMEZONE=UTC \
    APP_URL=http://localhost \
    DB_CONNECTION=mysql \
    DB_HOST=mysql \
    DB_PORT=3306 \
    DB_DATABASE=laravel \
    DB_USERNAME=sail \
    DB_PASSWORD=password

# Expose necessary ports
EXPOSE 80

# Run the application using php-fpm
CMD ["php-fpm"]
