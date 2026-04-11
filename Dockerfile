FROM php:8.2-apache

# Install MySQL PDO driver
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

# Fix permissions for Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80