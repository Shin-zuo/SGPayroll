FROM php:7.4-apache

# Configure Debian archive repositories and install system packages
RUN sed -i 's|deb.debian.org|archive.debian.org|g' /etc/apt/sources.list \
    && sed -i '/security/d' /etc/apt/sources.list \
    && sed -i '/updates/d' /etc/apt/sources.list \
    && apt-get -o Acquire::Check-Valid-Until=false update -y \
    && apt-get install -y \
    libmcrypt-dev \
    libxml2-dev \
    zlib1g-dev \
    libpng-dev \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    git \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql pdo_pgsql pgsql xml zip mbstring gd \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN sed -i 's/\r$//' /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

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

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["/usr/local/bin/start.sh"]