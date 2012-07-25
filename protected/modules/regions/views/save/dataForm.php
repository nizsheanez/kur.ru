<?php
$ids = CHtml::listData(Metric::getMetricWithDescendants($metric), 'id', 'id');
$data = Data::model()->metrics($ids)->sectors($sector->id)->findAll();

foreach ($data as $item)
{
    echo CHtml::label($item->metric->title, 'data['.$item->id.']');
    echo '<br />';
    echo CHtml::textField('data['.$item->id.']', $item->value);
    echo '<br />';
}