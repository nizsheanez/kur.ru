#!/bin/bash


. props.sh


cd $deploy_dir


#git pull
echo '-----------git pull-----------'
git pull > /dev/null
last_tag=$(git tag -l "*.*.*" | sort -V | tail -n 1)
git_tag=$(echo $last_tag | awk -F \. {'print $1"."$2"."++$3'})
git tag $git_tag && git push --tags

#rsync
echo '-----------rsync-----------'
rsync -azx --delete $deploy_dir $webroot


#clear cache
echo '-----------clear cache-----------'
rm -rf ${webroot}assets/
mkdir -m 777 ${webroot}assets/
rm -rf ${app_dir}runtime/
mkdir -m 777 ${app_dir}runtime/



#migate
echo '-----------migrate-----------'
php $yiic migrate up

#configuring
echo '-----------configuring-----------'
sed -f /var/overlays/phpenv.com/config.sed ${app_dir}config/production.tpl.php > ${app_dir}config/production.php
sed -f /var/overlays/phpenv.com/config.sed ${app_dir}config/main.tpl.php > ${app_dir}config/main.php

