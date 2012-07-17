<?php
class Square extends ActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'squares';
    }


    public function name()
    {
        return 'Модель Square';
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
                self::HAS_MANY, 'Polygon', 'square_id'
            ),
            'data' => array(
                self::HAS_MANY, 'SquareData', 'square_id'
            ),
        );
    }

    public function getProperties()
    {
        $base = array (
            'id' => $this->id,
            'name' => $this->name
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
        foreach (Square::model()->with(array('data', 'polygons', 'data.metric'))->findAll() as $square)
        {
            $tmp               = array();
            $tmp['type']       = "Polygon";
            $tmp['properties'] = $square->properties;

            foreach ($square->polygons as $polygon)
            {
                $tmp['coordinates'][] = $polygon->coordinates;
            }
            $res['features'][] = $tmp;
        }
        $res['metrics'] = CHtml::listData(Metric::model()->findAll(), 'name', 'attributes');

        return CJSON::encode($res);
    }
}