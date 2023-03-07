#!/bin/bash

DEPLOYMENT_VERSION=$1

isHigherThan(){
  echo $1 > temp-version-rollback
  echo $2 >> temp-version-rollback

  HIGHEST_VERSION=`cat temp-version-rollback | sort -rV | head -1`
  rm temp-version-rollback
  if [ $HIGHEST_VERSION = $2 ]; then return 1; else return 0;fi
}


for d in `ls -d database/migrations/*/ | sed -e 's/database\/migrations//g' | sed -e 's/\///g' | sort -rV`; do
  if (isHigherThan $d $DEPLOYMENT_VERSION); then
    echo "php artisan migrate:rollback --force --path=database/migrations/$d"
     php artisan migrate:rollback --force --path=database/migrations/$d
  fi
done
