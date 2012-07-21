<?
return CMap::mergeArray(require('main.php'), array(
    'components' => array(
        'db'           => array(
            'connectionString' => 'mysql:host=localhost;dbname=diplom',
            'emulatePrepare'   => true,
            'username'         => 'root',
            'password'         => '',
            'charset'          => 'utf8',
            'enableProfiling'  => true,
        ),
        'log'          => array(
            'class' => 'CLogRouter',
            'routes'=> array(
                array(
                    // направляем результаты профайлинга в ProfileLogRoute (отображается
                    // внизу страницы)
                    'class'  => 'CProfileLogRoute',
                    'levels' => 'profile',
                    'enabled'=> false,
                ),
            ),
        ),
    )
));
