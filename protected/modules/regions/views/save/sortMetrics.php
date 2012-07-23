<?php
$this->widget('regions.portlets.NestedTree', array(
    'model'    => Metric::model(),
    'sortable' => true,
    'id'       => 'metric_sorting'
));
