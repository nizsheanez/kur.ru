<?php
$this->widget('regions.portlets.NestedTree', array(
    'model'     => $model,
    'sortable'  => true,
    'id'        => $class . '_sorting',
    'sortUrl'   => '/regions/save/nested.sort',
    'deleteUrl' => '/regions/save/deleteMetric'
));
