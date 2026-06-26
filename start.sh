#!/bin/sh
set -e

echo "=== OFA Startup ==="
echo "DB_HOST=${DB_HOST}"
echo "DB_PORT=${DB_PORT}"
echo "DB_DATABASE=${DB_DATABASE}"
echo "APP_ENV=${APP_ENV}"
echo "PORT=${PORT:-8080}"

# Storage symlink (non-fatal)
php artisan storage:link --force 2>/dev/null || true

# Run migrations — if they fail, log the error but still start the server
echo "--- Running migrations ---"
php artisan migrate --force && echo "Migrations OK" || echo "WARNING: Migrations failed — check logs"

# Start server (exec replaces shell so signals are forwarded cleanly)
echo "--- Starting server on port ${PORT:-8080} ---"
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
