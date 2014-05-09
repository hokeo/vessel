#!/bin/sh
pwd
sudo apt-get update
sudo apt-get install apache2 libapache2-mod-fastcgi
# enable php-fpm
sudo cp ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf.default ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf
sudo a2enmod rewrite actions fastcgi alias
echo "cgi.fix_pathinfo = 1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
~/.phpenv/versions/$(phpenv version-name)/sbin/php-fpm
# configure apache virtual hosts
sudo cp -f build/travis-ci-apache /etc/apache2/sites-available/default
sudo a2ensite default
# make database
mysql -e 'create database vessel_testing;'
# update composer
composer self-update
# make app
cd ../../
ls
composer create-project laravel/laravel laravel --prefer-dist
cd laravel
composer install
cd ../
mkdir -p laravel/workbench/hokeo
mv hokeo/vessel laravel/workbench/hokeo
# composer vessel
cd laravel/workbench/hokeo/vessel
composer install --prefer-source --no-interaction --dev
touch is_travis_test
sudo service apache2 restart