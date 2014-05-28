#!/bin/bash

echo "Starting DB initialisation"

for file in `find /data/data/structure -type f | sort`
do
	echo 'Importing SQL file : '"$file"
	mysql opendtp < $file
done
