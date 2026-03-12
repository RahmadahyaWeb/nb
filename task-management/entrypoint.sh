#!/bin/sh

if [ ! -d "vendor" ]; then
  composer install
fi

if [ ! -d "node_modules" ]; then
  npm install
fi

npm run build

php artisan serve --host=0.0.0.0 --port=8000