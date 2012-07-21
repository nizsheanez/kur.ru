<?php
foreach ($sector->data as $item)
{
    if ($item->metric->inSubtreeOf($metric) || $item->metric->type == null)
    {
        echo CHtml::label($item->metric->title, 'data['.$item->id.']');
        echo '<br />';
        echo CHtml::textField('data['.$item->id.']', $item->value);
        echo '<br />';
    }
}