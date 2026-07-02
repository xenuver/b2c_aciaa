# Stage 1: Build Node.js assets
FROM node:22 AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Build PHP application
FROM composer:2.7 AS composer_builder
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Stage 3: Production Image
FROM serversideup/php:8.2-fpm-nginx

# Set environment variables for production
ENV APP_ENV=production \
    APP_DEBUG=false \
    PHP_OPCACHE_ENABLE=1

WORKDIR /var/www/html

# Copy application from previous stages
COPY --from=composer_builder /app /var/www/html
COPY --from=node_builder /app/public/build /var/www/html/public/build

# Fix permissions for Laravel storage and cache directories
USER root
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
USER www-data

# Create storage symlink
RUN php artisan storage:link
