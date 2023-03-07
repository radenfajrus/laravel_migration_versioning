#!/bin/bash

RUNNING_VERSION=$1

isHigherEqualThan(){
  echo $1 > temp-version-migrate
  echo $2 >> temp-version-migrate

  HIGHEST_VERSION=`cat temp-version-migrate | sort -rV | head -1`
  rm temp-version-migrate

  if [ $HIGHEST_VERSION = $1 ]; then return 0; else return 1;fi
}


for d in `ls -d database/migrations/*/ | sed -e 's/database\/migrations//g' | sed -e 's/\///g' | sort -V`; do
  if (isHigherEqualThan $d $RUNNING_VERSION); then
    echo "php artisan migrate --force --path=database/migrations/$d"
     php artisan migrate --force --path=database/migrations/$d
  fi
done
