<?php

return array(
    'language'     => 'ru',
    'basePath'     => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'         => '',

    'import'       => array(
        'application.components.*',
        'application.components.activeRecordBehaviors.*',
        'application.components.formElements.*',
        'application.components.bootstrap.widgets.*',
        'application.components.interfaces.*',
        'application.components.helpers.*',
        'application.components.Form',
        'application.components.validators.*',
        'application.components.zii.*',
        "application.components.zii.gridColumns.*",
        'application.components.baseWidgets.*',
        'application.components.bootstrap.widgets.*',
        'application.components.activeRecordBehaviors.*',
        'application.extensions.yiidebugtb.*',
    ),
    'preload'      => array(
        'log',
        'bootstrap'
    ),
    'modules'      => array(
        'dipl',
        'regions',
        'users',
        'rbac'
    ),
    'components'   => array(
        'fileBalancer' => array(
            'class'=> 'application.components.FileBalancer'
        ),
        'assetManager' => array(
            'class'       => 'CAssetManager',
            'newDirMode'  => 0755,
            'newFileMode' => 0644
        ),
        'session'      => array(
            'autoStart'=> true
        ),
        'cart'         => array(
            'class' => 'application.components.shoppingCart.EShoppingCart',
        ),
        'cache'        => array(
            'class'                => 'system.caching.CDbCache',
            'cacheTableName'       => 'cache',
            'autoCreateCacheTable' => true,
            'connectionID'         => 'db',
        ),
        'user'         => array(
            'allowAutoLogin' => true,
            'class'          => 'WebUser',
            'loginUrl'       => array('/users/user/login?redirect='.urlencode('/regions/index/index')),
        ),
        'image'        => array(
            'class'  => 'application.extensions.image.CImageComponent',
            'driver' => 'GD'
        ),
        'dater'        => array(
            'class' => 'application.components.DaterComponent'
        ),
        'text'         => array(
            'class' => 'application.components.TextComponent'
        ),
        'assetManager' => array(
            'class'       => 'AssetManager',
            'parsers'     => array(
                'sass' => array( // key == the type of file to parse
                    'class'   => 'ext.assetManager.Sass',
                    // path alias to the parser
                    'output'  => 'css',
                    // the file type it is parsed to
                    'options' => array(
                        'syntax' => 'sass'
                    )
                ),
                'scss' => array( // key == the type of file to parse
                    'class'   => 'ext.assetManager.Sass',
                    // path alias to the parser
                    'output'  => 'css',
                    // the file type it is parsed to
                    'options' => array(
                        'syntax' => 'scss',
                        'style'  => 'compressed'
                    )
                ),
                'less' => array( // key == the type of file to parse
                    'class'   => 'ext.assetManager.Less',
                    // path alias to the parser
                    'output'  => 'css',
                    // the file type it is parsed to
                    'options' => array()
                ),
            ),
            'newDirMode'  => 0755,
            'newFileMode' => 0644
        ),
        'urlManager'   => array(
            'urlFormat'      => 'path',
            'showScriptName' => false,
            'rules'          => array(
                '<controller:\w+>/<id:\d+>'                               => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'                  => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'                           => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<id:\d+>'                  => '<module>/<controller>/view',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'     => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>'              => '<module>/<controller>/<action>',
            ),
        ),

        'errorHandler' => array(
            'errorAction' => '/dipl/main/error',
        ),

        'authManager'  => array(
            'class' => 'DbAuthManager',
            'connectionID'    => 'db',
            'itemTable'       => 'auth_items',
            'assignmentTable' => 'auth_assignments',
            'itemChildTable'  => 'auth_items_childs',
            'defaultRoles' => array('guest'),
        ),
        'bootstrap'    => array(
            'class'=> 'application.components.bootstrap.components.Bootstrap'
        ),

        'log'          => array(
            'class' => 'CLogRouter',
            'routes'=> array( //                array(
                // направляем результаты профайлинга в ProfileLogRoute (отображается
                // внизу страницы)
//                    'class'=>'CProfileLogRoute',
//                    'levels'=>'profile',
//                    'enabled'=>true,
//                )
//                array(
//                    'class'        => 'ext.debug.db_profiler.DbProfileLogRoute',
//                    'countLimit'   => 1,
//                    // How many times the same query should be executed to be considered inefficient
//                    'slowQueryMin' => 0.01,
//                    // Minimum time for the query to be slow
//                ),
            ),
        ),
    ),
    'params'       => array(
        'save_site_actions'           => false,
        'multilanguage_support'       => false,
        'collect_routes_from_modules' => false,
        'themes_enabled'              => false
    )
);