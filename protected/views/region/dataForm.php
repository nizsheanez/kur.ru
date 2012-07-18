<?php
foreach (Metric::model()->findAll() as $model)
{
    $item = Data::model()->findByAttributes(array('sector_id' => $sector->id, 'metric_id' => $model->id));
    if ($model->inSubtreeOf($metric) || $model->type == null)
    {
        echo CHtml::label($model->title, 'data['.$item->id.']');
        echo '<br />';
        echo CHtml::textField('data['.$item->id.']', $item->value);
        echo '<br />';
    }
}