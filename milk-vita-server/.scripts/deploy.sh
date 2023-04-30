#!/bin/bashs
set -e

echo "Deployment started ...."

# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down) || true

# Pull the latest version of the app
# git pull origin main

# Install composer dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
php artisan clear-compiled

# Recreate cache
php artisan optimize

# Cache Clear
php artisan config:cache 

#install packagess
# npm install
# Compile npm assets
# npm run prod

# Run database migrations
php artisan migrate --force

#set file permission
chown $USER:www-data storage -R
chmod 777 storage -R

# Exit maintenance mode
php artisan up

# php artisan websockets:serve

#done
echo "Deployment finished!"