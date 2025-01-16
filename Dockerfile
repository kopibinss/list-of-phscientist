# Build Stage
FROM composer:2.6 AS builder
WORKDIR /app
COPY . /app
RUN composer install --optimize-autoloader --no-dev

# Production Stage
FROM php:8.3-fpm
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql bcmath

# Install MySQL Server (if you want MySQL server in the same container)
RUN apt-get install -y mysql-server && \
    service mysql start && \
    mysql -e "CREATE DATABASE IF NOT EXISTS ${DB_DATABASE};" && \
    mysql -e "CREATE USER IF NOT EXISTS '${DB_USERNAME}'@'%' IDENTIFIED BY '${DB_PASSWORD}';" && \
    mysql -e "GRANT ALL PRIVILEGES ON ${DB_DATABASE}.* TO '${DB_USERNAME}'@'%';" && \
    mysql -e "FLUSH PRIVILEGES;"

# Copy application and set permissions
COPY --from=builder /app /var/www/html

ARG WWWGROUP=1000
ARG WWWUSER=1000
RUN groupadd -g "$WWWGROUP" sail || true && \
    useradd -u "$WWWUSER" -g sail -m sail || true && \
    chown -R "$WWWUSER":"$WWWGROUP" /var/www/html

# Expose PHP-FPM port
EXPOSE 10000

# Start PHP-FPM and MySQL server
CMD service mysql start && php artisan serve --host=0.0.0.0 --port=${PORT}
