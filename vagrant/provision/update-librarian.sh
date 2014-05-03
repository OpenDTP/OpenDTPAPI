#!/bin/bash

cd /vagrant/puppet
if [[ ! -e /vagrant/puppet/Puppetfile.lock ]]
then
	echo "install librarian-puppet"
	librarian-puppet install
else
	echo "Updating librarian-puppet"
	librarian-puppet update
fi
