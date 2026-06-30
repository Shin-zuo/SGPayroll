FROM php:7.1-apache

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# This sets your script to run before the command
ENTRYPOINT ["docker-entrypoint.sh"]

# Your existing start command (e.g., apache2-foreground)
CMD ["apache2-foreground"]

# Fix Debian archive repositories because Debian 9 (Stretch) is EOL
RUN sed -i -e 's/deb.debian.org/archive.debian.org/g' \
           -e 's|security.debian.org|archive.debian.org/|g' \
           -e '/stretch-updates/d' /etc/apt/sources.list \
    && apt-get update -y && apt-get install -y \
    libmcrypt-dev \
    libxml2-dev \
    zlib1g-dev \
    libpng-dev \
    libpq-dev \
    git \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql pdo_pgsql pgsql mcrypt xml zip mbstring gd \
    && a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy the application code
COPY . .

# Install dependencies (run without dev, scripts and interactions)
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist

# Change the DocumentRoot to public directory
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Give proper permissions to web server
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Create a startup script to dynamically bind Apache to Render's $PORT
RUN echo '#!/bin/bash\n\
sed -i "s/80/${PORT:-80}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf\n\
apache2-foreground' > /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

# Render will provide the PORT environment variable
ENV PORT=10000

COPY cacert.pem /var/www/html/cacert.pem

# Start the startup script
CMD ["/usr/local/bin/start.sh"]

# RUN php artisan migrate --force