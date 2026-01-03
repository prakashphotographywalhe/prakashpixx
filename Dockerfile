# Use a professional PHP + Apache image
FROM php:8.2-apache

# Install the PostgreSQL driver so your site can talk to the database
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql

# Copy all your website files into the server folder
COPY . /var/www/html/

# Make sure the server can read your files
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80