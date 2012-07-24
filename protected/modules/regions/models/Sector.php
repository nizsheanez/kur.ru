<?php
class Sector extends ActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'sectors';
    }


    public function name()
    {
        return 'Модель Sector';
    }


    public function rules()
    {
        return array(
            array(
                'name',
                'safe'
            ),
        );
    }


    public function relations()
    {
        return array(
            'polygons' => array(
                self::HAS_MANY,
                'Polygon',
                'sector_id'
            ),
            'square'   => array(
                self::BELONGS_TO,
                'Square',
                'square_id'
            ),
            'data'     => array(
                self::HAS_MANY,
                'Data',
                'sector_id'
            ),
        );
    }


    public function getProperties()
    {
        $base = array(
            'id'        => (int)$this->id,
            'name'      => $this->title,
            'square_id' => (int)$this->square_id
        );
        $ext  = array();
        foreach ($this->data as $item)
        {
            $ext[$item->metric->name] = (float)$item->value;
        }
        return array_merge($base, $ext);
    }


    public static function getJson()
    {
        $res = array('type' => "FeatureCollection");
        foreach (
            Sector::model()->with(array(
                'data',
                'polygons',
                'data.metric'
            ))->findAll() as $sector)
        {
            $tmp               = array();
            $tmp['type']       = "Polygon";
            $tmp['properties'] = $sector->properties;

            foreach ($sector->polygons as $polygon)
            {
                $tmp['coordinates'][] = $polygon->coordinates;
            }
            $res['features'][$sector->id] = $tmp;
        }
        $res['metrics'] = CHtml::listData(Metric::model()->findAll(), 'name', 'attributes');

        return CJSON::encode($res);
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                foreach (Metric::model()->findAll() as $metric)
                {
                    $data = new Data();
                    $data->metric_id = $metric->id;
                    $data->sector_id = $this->id;
                    $data->save();
                }
                return true;
            }
        }
        return false;
    }

}