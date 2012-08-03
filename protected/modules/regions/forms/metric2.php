<?php

return array(
    'action' => '/regions/save/createMetric',
    'activeForm'     => array(
        'id'     => 'metric-form',
    ),
    'elements'       => array(
        'title'      => array('type' => 'text'),
        'name'       => array('type' => 'text'),
        'type'       => array('type' => 'dropdownlist', 'items' => Metric::$types),
    ),
    'buttons'        => array(
        'submit' => array(
            'type'  => 'submit',
//            'value' => 'Продолжить',
            'value' => 'сохранить'
        )
    )
);


