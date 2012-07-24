<?php
$app_dir = realpath('../www/protected');
$deploy_dir = realpath('../deploy');
class Utilits{

    public static $shell_version_next = '';
}
//
//$properties = require 'conf/doc.php';
//$properties = require 'conf/sync.php';



git($deploy_dir);

function git($deploy_dir)
{
    system('
        cd '.$deploy_dir.'
        echo "git pull: start"
        git pull
        echo "git pull: end"
        pwd
        last_tag=git tag -l "*.*.*" | sort -V | tail -n 1
        echo $last_tag | awk -F \. {"print $1\'.\'$2\'.\'++$3"}
        git tag $git_tag && git push --tags
    ');
}