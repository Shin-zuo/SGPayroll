#!/bin/sh
# Remove the 'set -e' so a failed migration doesn't kill the container

echo "Running migrations against TiDB Cloud..."
# The '|| true' prevents the script from exiting if the migration fails
php artisan migrate --force || echo "MIGRATION FAILED - Check your TiDB connection, credentials, or SSL setup."

# Start the web server anyway so you can read logs or test the site
exec "$@"