# Step 1: Use the official PHP image with FPM (FastCGI Process Manager)
FROM php:8.1-fpm

# Step 2: Install required dependencies
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

# Step 5: Install Composer (PHP dependency manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Step 6: Install Laravel dependencies using Composer
RUN composer install --optimize-autoloader --no-dev

# Step 7: Expose port 9000 for PHP-FPM
EXPOSE 9000

# Step 8: Start the PHP-FPM server
CMD ["php-fpm"]
