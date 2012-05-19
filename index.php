<?php
//doing
define ('YII_DEBUG', true);

// include Yii bootstrap file
require_once(dirname(__FILE__).'/framework/yii.php');
$config=dirname(__FILE__).'/protected/config/main.php';

// create a Web application instance and run
Yii::createWebApplication($config)->run();