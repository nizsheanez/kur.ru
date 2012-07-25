<?php
class Metric extends ActiveRecord
{
    const LFT   = 'lft';
    const RGT   = 'rgt';
    const DEPTH = 'depth';


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'metrics';
    }


    public function name()
    {
        return 'Модель Metric';
    }


    public function rules()
    {
        return array(
            array(
                'title, name, type, formula, min, norma, max',
                'safe'
            ),
        );
    }

    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
            'tree'       => array(
                'class'         => 'application.components.activeRecordBehaviors.NestedSetBehavior',
                'leftAttribute' => self::LFT,
                'rightAttribute'=> self::RGT,
                'levelAttribute'=> self::DEPTH,
            ),
        ));
    }


    public function inSubtreeOf($metric)
    {
        $ancestors = $this->ancestors()->findAll();
        $ancestors[] = $this;
        foreach ($ancestors as $item)
        {
            if ($item->name == $metric)
            {
                return true;
            }
        }
        return false;
    }


    public static function getHtmlTree()
    {
        $models = self::getRoot()->descendants()->findAll();

        $depth = 0;
        $res   = '';

        foreach ($models as $n=> $item)
        {
            if ($item->depth == $depth)
            {
                $res .= CHtml::closeTag('li') . "\n";
            }
            else if ($item->depth > $depth)
            {
                $res .= CHtml::openTag('ul', array('class' => 'depth_' . $item->depth)) . "\n";
            }
            else
            {
                $res .= CHtml::closeTag('li') . "\n";

                for ($i = $depth - $item->depth; $i; $i--)
                {
                    $res .= CHtml::closeTag('ul') . "\n";
                    $res .= CHtml::closeTag('li') . "\n";
                }
            }

            $res .= CHtml::openTag('li', array(
                'id'   => 'items_' . $item->id,
                'class'=> 'depth_' . $item->depth
            ));
            $res .= CHtml::tag('div', array(), CHtml::encode($item->title) .
                '<img class="drag" src="/img/admin/hand.png" height="16" width="16" />');
            $depth = $item->depth;
        }

        for ($i = $depth; $i; $i--)
        {
            $res .= CHtml::closeTag('li') . "\n";
            $res .= CHtml::closeTag('ul') . "\n";
        }

        return $res;
    }


    public static function getRoot()
    {
        return self::model()->roots()->find();
    }

    public static function getMetricWithDescendants($name)
    {
        $metric = Metric::model()->findByAttributes(array('name' => $name));
        $metrics = $metric->descendants()->findAll();
        $metrics[] = $metric;
        return $metrics;
    }

    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                foreach (Sector::model()->findAll() as $sector)
                {
                    $data = new Data();
                    $data->metric_id = $this->id;
                    $data->sector_id = $sector->id;
                    $data->save();
                }
                return true;
            }
        }
        return false;
    }

}