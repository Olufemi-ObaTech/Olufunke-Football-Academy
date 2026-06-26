#!/bin/sh
set -e

echo "=== OFA Startup ==="
echo "DB_HOST=${DB_HOST}"
echo "DB_PORT=${DB_PORT}"
echo "DB_DATABASE=${DB_DATABASE}"
echo "APP_ENV=${APP_ENV}"
echo "PORT=${PORT:-8080}"

php artisan storage:link --force 2>/dev/null || true
php artisan config:clear 2>/dev/null || true
php artisan cache:clear  2>/dev/null || true

echo "--- Running migrations ---"
php artisan migrate --force && echo "Migrations OK" || echo "WARNING: Migrations failed"

echo "--- Running seeders ---"
php artisan db:seed --class=AdminSeeder --force      && echo "AdminSeeder OK"      || echo "AdminSeeder failed"
php artisan db:seed --class=AcademySeeder --force    && echo "AcademySeeder OK"    || echo "AcademySeeder failed"
php artisan db:seed --class=Season2526Seeder --force && echo "Season2526Seeder OK" || echo "Season2526Seeder failed"
php artisan db:seed --class=QuizSeeder --force       && echo "QuizSeeder OK"       || echo "QuizSeeder failed"
php artisan db:seed --class=QuizWeek2Seeder --force       && echo "QuizWeek2Seeder OK"       || echo "QuizWeek2Seeder failed"
php artisan db:seed --class=PostImageUpdateSeeder --force && echo "PostImageUpdateSeeder OK" || echo "PostImageUpdateSeeder failed"

# Force database sessions — file sessions are lost on every container restart.
# Force secure cookie off — Railway terminates SSL at the proxy edge.
export SESSION_DRIVER=database
export SESSION_SECURE_COOKIE=false
export SESSION_DOMAIN=

echo "--- Starting server on port ${PORT:-8080} ---"
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
