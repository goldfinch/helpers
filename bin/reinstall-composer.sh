#!/bin/bash

rm -rf vendor/
rm -rf composer.lock
rm -rf public/_resources/
composer clearcache
composer install --ignore-platform-reqs
php vendor/silverstripe/framework/cli-script.php dev/build "flush=1"
cp vendor/goldfinch/taz/taz taz
