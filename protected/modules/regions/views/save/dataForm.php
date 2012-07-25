<?php
$data = Data::model()->metrics($metric_ids)->sectors($sector->id)->findAll();

foreach ($data as $item)
{
    echo CHtml::label($item->metric->title, 'data['.$item->id.']');
    echo '<br />';
    echo CHtml::textField('data['.$item->id.']', $item->value);
    echo '<br />';
}