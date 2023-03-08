#!/bin/bash

set -e
echo "Deployment started ..."

#php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
#php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
#php composer-setup.php
#php -r "unlink('composer-setup.php');"
#./composer.phar install --no-dev --no-interaction --prefer-dist --optimize-autoloader

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

(php artisan down) || true

php artisan clear-compiled
php artisan optimize:clear

npm install
npm run build

php artisan up
echo "Deployment finished!"