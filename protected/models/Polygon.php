<?php
class Polygon extends ActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'polygons';
    }


    public function name()
    {
        return 'Модель Polygon';
    }


    public function rules()
    {
        return array(
            array(
                'lat, lng, sector_id', 'safe'
            ),
        );
    }


    public function relations()
    {
        return array(
            'sector' => array(
                self::BELONGS_TO, 'Sector', 'sector_id'
            ),
        );
    }

    public function getCoordinates()
    {
        return array($this->lat, $this->lng);
    }
}