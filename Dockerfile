# Step 1: Set up the base image for PHP and install necessary dependencies
FROM php:8.1-fpm

# Step 2: Install dependencies for MySQL and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    unzip \
    libmysqlclient-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Step 3: Set the working directory inside the container
WORKDIR /var/www

# Step 4: Copy the application code from the host machine to the container
COPY . .

# Step 5: Install Composer (dependency manager for PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Step 6: Install Laravel dependencies using Composer
RUN composer install --optimize-autoloader --no-dev

# Step 7: Set up the Nginx server for PHP
FROM nginx:latest

# Step 8: Copy Nginx configuration
COPY ./nginx/default.conf /etc/nginx/conf.d/

# Step 9: Expose port 80 for web traffic
EXPOSE 80

# Step 10: Start PHP-FPM and Nginx services
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
