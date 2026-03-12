#!/bin/sh

# install composer dependencies
if [ ! -d "vendor" ]; then
  echo "Installing composer dependencies..."
  composer install
fi

# install npm dependencies
if [ ! -d "node_modules" ]; then
  echo "Installing npm dependencies..."
  npm install
fi

# generate app key jika belum ada
if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
  echo "Generating APP_KEY..."
  php artisan key:generate
fi

# build frontend
echo "Building frontend..."
npm run build

# start laravel
echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=8000