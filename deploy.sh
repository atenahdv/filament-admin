#!/bin/bash
set -e

cd /home/cp61664/filament.atenahadavi.com


/opt/cpanel/composer/bin/composer install --no-dev --optimize-autoloader

php artisan down || true
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link || true
php artisan up

echo "Deployment complete!"
