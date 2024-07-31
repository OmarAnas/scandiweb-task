# Use the official PHP image with Apache
FROM php:7.4-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy the application source code into the container
COPY . /var/www/html/

# Expose port 80 for HTTP traffic
EXPOSE 80

# Optionally install additional PHP extensions if needed
RUN docker-php-ext-install pdo 
RUN docker-php-ext-install pdo_mysql

