FROM php:8.2-apache

# Install PostgreSQL PDO driver
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Enable Apache rewrite module
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

# Fix permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Render requires port 10000
EXPOSE 10000

# Start Apache on Render's required port
CMD ["apache2-foreground"]