<?php
class Metric extends ActiveRecord
{
    const LFT   = 'lft';
    const RGT   = 'rgt';
    const DEPTH = 'depth';

    const TYPE_SECTOR = 1;
    const TYPE_SQUARE = 2;

    public static $types = array(
        self::TYPE_SECTOR => 'Сектор',
        self::TYPE_SQUARE => 'Квартал'
    );

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
                'title, name, type',
                'required',
                'on' => 'create'
            ),
            array(
                'formula, min, norma, max',
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


    public function relations()
    {
        return array(
            'data' => array(
                self::HAS_MANY, 'Data', 'metric_id'
            ),
        );
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

    public function afterSave()
    {
        parent::afterSave();
        if (count($this->data) == 0)
        {
            foreach (Sector::model()->findAll() as $sector)
            {
                $data = new Data();
                $data->metric_id = $this->id;
                $data->sector_id = $sector->id;
                $data->save();
            }
        }
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            foreach ($this->data as $data)
            {
                $data->delete();
            }
            return true;
        }
        return false;
    }
}