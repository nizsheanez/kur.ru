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
                'name', 'safe'
            ),
        );
    }


    public function relations()
    {
        return array(
            'polygons' => array(
                self::HAS_MANY, 'Polygon', 'sector_id'
            ),
            'data' => array(
                self::HAS_MANY, 'Data', 'sector_id'
            ),
        );
    }

    public function getProperties()
    {
        $base = array (
            'id' => $this->id,
            'name' => $this->title
        );
        $data = array();
        foreach ($this->data as $item)
        {
            $data[$item->metric->name] = $item->value;
        }
        return array_merge($base, $data);
    }

    public static function getJson()
    {
        $res = array('type' => "FeatureCollection");
        foreach (Sector::model()->with(array('data', 'polygons', 'data.metric'))->findAll() as $sector)
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
}