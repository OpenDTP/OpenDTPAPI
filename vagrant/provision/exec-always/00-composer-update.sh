#!/bin/bash

echo "Installing composer dependencies"

cd /data
composer self-update
composer update
vendor/bin/phing build
chmod -R 777 /storage
chown -R vagrant: /storage
