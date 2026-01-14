# Multi-stage build untuk Laravel + Vue.js
FROM node:20-alpine AS frontend-builder

WORKDIR /app/frontend

# Copy package files
COPY frontend/package*.json ./

# Install dependencies
RUN npm ci

# Copy frontend source
COPY frontend/ ./

# Build frontend dengan production mode
ENV NODE_ENV=production
RUN npm run build

# Stage 2: PHP dengan Composer
FROM php:8.2-fpm-alpine AS backend-builder

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    postgresql-dev \
    mysql-client \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app/backend

# Copy composer files
COPY backend/composer*.json ./

# Copy minimal files yang dibutuhkan untuk composer scripts (artisan, bootstrap)
COPY backend/artisan ./
COPY backend/bootstrap ./bootstrap

# Install PHP dependencies (dengan scripts karena artisan sudah ada)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy sisa backend source
COPY backend/ ./

# Copy built frontend files ke public directory
COPY --from=frontend-builder /app/frontend/dist ./public/frontend

# Set permissions
RUN chown -R www-data:www-data /app/backend/storage /app/backend/bootstrap/cache
RUN chmod -R 775 /app/backend/storage /app/backend/bootstrap/cache

# Stage 3: Production image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    postgresql-dev \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath gd

# Copy built application
COPY --from=backend-builder /app/backend /var/www/html

# Copy nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf

# Copy supervisor configuration
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set working directory
WORKDIR /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 8080

# Start supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

