#!/bin/sh
set -e

# Run migrations first
echo "Running migrations..."
php artisan migrate --force

# Then start your web server (Apache/Nginx)
exec "$@"