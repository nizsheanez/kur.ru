<?php

return array(
    'action' => '/regions/save/polygons',
    'activeForm'     => array(
        'id'     => 'metric-form',
    ),
    'elements'       => array(
        'title'      => array('type' => 'text'),
        'square_id'  => array('type' => 'dropdownlist', 'items' => CHtml::listData(Square::model()->findAll(), 'id', 'title')),
    ),
    'buttons'        => array(
        'submit' => array(
            'type'  => 'submit',
            'value' => 'сохранить'
        )
    )
);


