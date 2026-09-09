#!/bin/sh

# If vendor/autoload.php is missing (e.g. if host volume was mounted without vendor)
if [ ! -f /var/www/html/vendor/autoload.php ]; then
    echo "vendor/autoload.php not found. Installing composer dependencies..."
    composer install --no-dev --no-scripts --no-interaction --prefer-dist
fi

# Ensure storage and bootstrap/cache permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

echo "Running migrations..."
# The '|| true' prevents the script from exiting if the migration fails
php artisan migrate --force || echo "Migration notice - Check database connection or credentials."

# Start the web server anyway so you can read logs or test the site
exec "$@"