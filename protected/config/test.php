<?php

return CMap::mergeArray(require('development.php'), array(
    'components'=> array(
        'session' => array(
            'autoStart' => true
        ),
        'db'      => array(
            'connectionString'=> 'mysql:host=localhost;dbname=svet',
            'username'        => 'root',
            'password'        => '',
            'charset'         => 'utf8',
        ),
        'fixture' => array(
            'class'   => 'system.test.CDbFixtureManager',
            'basePath'=> dirname(__FILE__).'/../tests/fixtures',
        ),
    ),
));
