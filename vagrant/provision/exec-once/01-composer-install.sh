#!/bin/bash

echo "Installing composer dependencies"

export APPLICATION_ENV=developpement

cd /data
composer self-update
composer install
vendor/bin/phing deploy
