# Use the official PHP image with Apache
FROM php:8.2-apache

# Enable PDO and PostgreSQL extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Copy project files into the container
COPY . /var/www/html/

# Expose port 80
EXPOSE 80