# Weezevent Dev Server manifest
# Designed for Debian Wheezy server by Michael FORASTE

# loading server section
if $ssh_values == undef {
  $ssh_values = hiera('ssh', false)
}
if $server_values == undef {
  $server_values = hiera('server', false)
}
$username = $ssh_values['username']

####################################################
###                Server Setup                  ###
####################################################

# Ensure the time is accurate, reducing the possibilities of apt repositories
# failing for invalid certificates
include '::ntp'

# Declaring exec bin paths
Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/' ] }

# creating groups
group { 'puppet':   ensure => present }
group { 'www-data': ensure => present }

# creating user ssh declarated in hiera.yaml
user { $username:
  shell  => '/bin/bash',
  home   => "/home/${username}",
  ensure => present
}

# creating apache user for Apache
user { ['apache']:
  shell  => '/bin/bash',
  ensure => present,
  groups => 'www-data',
  require => Group['www-data']
}

# creating ssh user home
file { "/home/${username}":
    ensure => directory,
    owner  => $username,
}

# installing curl
include curl

# copy dot files to ssh user's home directory
exec { "dotfiles":
  cwd     => "/home/${username}",
  command => "cp -r /vagrant/puppet/files/dot/.[a-zA-Z0-9]* /home/${username}/ \
              && chown -R ${username} /home/${username}/.[a-zA-Z0-9]*",
  onlyif  => 'test -d /vagrant/puppet/files/dot',
  returns => [0, 1],
  require => User[$username]
}

# Creating git bash prompt
exec { 'bash_git':
  cwd     => "/home/${username}",
  command => "curl https://raw.github.com/git/git/master/contrib/completion/git-prompt.sh > /home/${username}/.bash_git",
  creates => "/home/${username}/.bash_git"
}

file_line { 'link ~/.bash_git':
  ensure  => present,
  line    => 'if [ -f ~/.bash_git ] ; then source ~/.bash_git; fi',
  path    => "/home/${username}/.bashrc",
  require => [
    Exec['dotfiles'],
    Exec['bash_git'],
    Package['curl']
  ]
}

# Use init instead of upstart.
# Upstart is not fully supported with Debian but now a standard on Ubuntu.
Service {
  provider => 'init',
}

# Ensure aditional packages
if !empty($server_values['packages']) {
  ensure_packages( $server_values['packages'] )
}

####################################################
###                Apache Setup                  ###
####################################################

if $apache_values == undef {
  $apache_values = hiera('apache', false)
}

# installing Apache
class { 'apache':
  conf_template => '/vagrant/puppet/templates/apache/httpd.conf.erb',
  user          => 'www-data',
  group         => 'www-data',
  default_vhost => false,
  mpm_module    => prefork,
  manage_user   => false,
  manage_group  => false
}

file { "/var/log/apache2":
  ensure => directory,
  recurse => true,
  owner => "www-data",
  group => "www-data",
  mode => 0644
}

# Additional declared VHosts
if count($apache_values['vhosts']) > 0 {
  create_resources(apache::vhost, $apache_values['vhosts'])
}

## Additionnal modules
## in this manifest modules php5, memcached and mysql are already includes
apache::mod { $apache_values['modules']: }

####################################################
###                PHP Setup                     ###
####################################################

if $php_values == undef {
  $php_values = hiera('php', false)
}

# installing php
class { 'php':
  service => 'apache2'
}

# installing apache php mod
apache::mod { ['php5']: }

# Setting up composer
exec {'install-composer' :
  cwd => '/tmp',
  command => "curl -sS https://getcomposer.org/installer | php && \
              mv composer.phar /usr/local/bin/composer",
  onlyif  => "test ! -e /usr/local/bin/composer",
  require => Package['curl']
}

# Additional php modules
php::module { $php_values['modules']: }

####################################################
###                XDebug Setup                  ###
####################################################

# Installing xdebug package
package { 'xdebug':
  name   => 'php5-xdebug',
  ensure => 'installed',
  require => Class['php']
}

# XDebug configuration file
file { '/etc/php5/mods-available/xdebug.ini' :
  content => template('/vagrant/puppet/templates/xdebug/ini_file.erb'),
  ensure  => present,
  require => Package['xdebug'],
  notify  => Service['apache2']
}

####################################################
###                Mailcatcher Setup             ###
####################################################

if $mailcatcher_values == undef {
  $mailcatcher_values = hiera('mailcatcher', false)
}

user { 'mailcatcher':
  ensure           => 'present',
  comment          => 'Mailcatcher Mock Smtp Service User',
  home             => '/var/spool/mailcatcher',
  shell            => '/bin/true',
}

package { ['ruby-dev','sqlite3','libsqlite3-dev', 'rubygems'] :
  ensure => 'present'
} ->
package { 'mailcatcher':
  ensure   => 'present',
  provider => 'gem'
}

# Setting up options
$options = sort(join_keys_to_values({
  ' --smtp-ip'   => $mailcatcher_values['smtp_ip'],
  ' --smtp-port' => $mailcatcher_values['smtp_port'],
  ' --http-ip'   => $mailcatcher_values['http_ip'],
  ' --http-port' => $mailcatcher_values['http_port']
}, ' '))

# Creating mailcatcher config file
file {'/etc/init.d/mailcatcher':
  ensure  => 'file',
  content => template('/vagrant/puppet/templates/mailcatcher/mailcatcher.conf.erb'),
  mode    => '0755'
}

file {'/var/log/mailcatcher':
  ensure  => 'directory',
  owner   => 'mailcatcher',
  group   => 'mailcatcher',
  mode    => '0755',
  require => User['mailcatcher']
}

service {'mailcatcher':
  ensure     => 'running',
  hasstatus  => true,
  hasrestart => true,
  subscribe => File['/etc/init.d/mailcatcher']
}

# Reverse proxypass for mailcatcher
apache::vhost { $mailcatcher_values['name']:
  docroot => '/var/www',
  port    => '80',
  proxy_dest => 'http://127.0.0.1:1080'
}

####################################################
###                Webgrind Setup                ###
####################################################

if $webgrind_values == undef {
  $webgrind_values = hiera('webgrind', false)
}

vcsrepo { "/var/www/webgrind":
    ensure => 'latest',
    provider => 'git',
    source => 'git://github.com/jokkedk/webgrind.git',
    revision => 'master',
}

package { 'graphviz' :
  ensure => 'installed'
}

file { '/usr/local/bin/dot':
   ensure => 'link',
   target => '/usr/bin/dot',
   require => Package['graphviz']
}

apache::vhost { $webgrind_values['name']:
  docroot => '/var/www/webgrind',
  port    => '80'
}

####################################################
###                Memcached Setup               ###
####################################################

if $phpmemcachedadmin_values == undef {
  $phpmemcachedadmin_values = hiera('phpmemcachedadmin', false)
}

# Installing memcached package
package { 'memcached' :
  ensure => 'present'
}

# Installing php module
php::module { "memcached": }

# Installing PHPMemcachedAdmin tarball
exec {'install-phpMemcachedAdmin' :
  cwd => '/tmp',
  command => "mkdir phpmemcachedadmin \
              && wget http://phpmemcacheadmin.googlecode.com/files/phpMemcachedAdmin-1.2.2-r262.tar.gz \
              && tar -xvzf phpMemcachedAdmin-1.2.2-r262.tar.gz -C phpmemcachedadmin \
              && mv phpmemcachedadmin /var/www/ \
              && rm phpMemcachedAdmin-1.2.2-r262.tar.gz",
  onlyif  => "test ! -e /var/www/phpmemcachedadmin/index.php"
}

# Setting vhost
apache::vhost { $phpmemcachedadmin_values['name']:
  docroot => '/var/www/phpmemcachedadmin',
  port    => '80'
}

####################################################
###                MySQL Setup                   ###
####################################################

if $db_values == undef {
  $db_values = hiera('databases', false)
}

include ::mysql::server

# Installing php module
php::module { "mysql": }

define mysql_db (
  $user,
  $password,
  $host     = 'localhost',
  $grant    = ['ALL'],
  $sql_file = false
) {
  if $name == '' or $password == '' or $host == '' {
    fail( 'MySQL DB requires that name, password and host be set. Please check your settings!' )
  }

  mysql::db { $name:
    user     => $user,
    password => $password,
    host     => $host,
    grant    => $grant,
    sql      => $sql_file,
  }
  mysql_grant { "${user}@localhost/${db}.*":
    ensure => 'present',
    options    => ['GRANT'],
    privileges => $grant,
    table      => "${db}.*",
    user       => '${user}@localhost'
  }
}

if is_hash($db_values) {
  create_resources(mysql_db, $db_values)
}

####################################################
###                PHPMyAdmin Setup              ###
####################################################

if $phpmyadmin_values == undef {
  $phpmyadmin_values = hiera('phpmyadmin', false)
}

# Installing phpmyadmin package
package { 'phpmyadmin' :
  ensure => 'present'
}

apache::vhost { $phpmyadmin_values['name']:
  docroot => '/usr/share/phpmyadmin',
  port    => '80'
}
