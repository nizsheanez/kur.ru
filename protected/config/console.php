<?php
return CMap::mergeArray(require(CONFIG . '.php'), array(
    'language'   => 'en',
    'commandMap' => array(
        'migrate'    => array(
            'class' => 'ext.migrate.EMigrateCommand',
        ),
    ),
));
