#!/bin/bash

DEPLOYMENT_COMMIT=`[ -z $1 ] && echo 'prod' || echo $1`

set -e
echo "Deployment started ..."
(php artisan down) || true

git stash
git fetch --all
git checkout $DEPLOYMENT_COMMIT
git pull

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

php artisan clear-compiled
php artisan optimize

npm run prod

php artisan up
echo "Deployment finished!"