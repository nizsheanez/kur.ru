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


    public static function getRoot()
    {
        return self::model()->roots()->find();
    }

    public function getMetricWithDescendants()
    {
        $metrics = $this->descendants()->findAll();
        $metrics[] = $this;
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
            }
            return true;
        }
        return false;
    }

}