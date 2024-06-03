#!/bin/bash

composer dump-autoload --optimize
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
npm run build
php artisan storage:link
