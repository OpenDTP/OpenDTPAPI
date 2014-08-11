#!/bin/bash

RUN_ONCE='/.run_once_tmp'

shopt -s nullglob
files=(/vagrant/provision/exec-once/*)

if [[ ! -f $RUN_ONCE && (${#files[@]} -gt 0) ]]; then
  echo 'Running files in vagrant/provision/exec-once'
  for script in `find "/vagrant/provision/exec-once" -maxdepth 1 -type f \( ! -iname "empty" \)`
	do
		echo 'Executing script '$script
		chmod +x $script
		$script
	done
  echo 'Finished running files in vagrant/provision/exec-once'
  echo 'To run again, delete file' $RUN_ONCE
  touch $RUN_ONCE
fi

echo 'Running files in vagrant/provision/exec-always'
for script in `find "/vagrant/provision/exec-always" -maxdepth 1 -type f \( ! -iname "empty" \)`
do
	echo 'Executing script '$script
	chmod +x $script
	$script
done
echo 'Finished running files in vagrant/provision/exec-always'
