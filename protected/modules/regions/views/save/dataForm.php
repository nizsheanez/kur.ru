<?php
$metric = Metric::model()->findByAttributes(array('name' => $metric));
$metrics = $metric->descendants()->findAll();

$ids = CHtml::listData($metrics, 'id', 'id');
$ids[$metric->id] = $metric->id;
$data = Data::model()->inCondition('metric_id', CHtml::listData($metrics, 'id', 'id'))->findAllByAttributes(array(
    'sector_id' => $sector->id,
));

foreach ($data as $item)
{
    echo CHtml::label($item->metric->title, 'data['.$item->id.']');
    echo '<br />';
    echo CHtml::textField('data['.$item->id.']', $item->value);
    echo '<br />';
}