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
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql bcmath

# Copy application and set permissions
COPY --from=builder /app /var/www/html
RUN groupadd -g "$WWWGROUP" sail || true && \
    useradd -u "$WWWUSER" -g sail -m sail || true && \
    chown -R "$WWWUSER":"$WWWGROUP" /var/www/html

# Expose PHP-FPM port
EXPOSE ${PORT}


CMD ["php-fpm"]
