<?php
class Data extends ActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'data';
    }


    public function name()
    {
        return 'Модель Data';
    }


    public function rules()
    {
        return array(
            array(
                'value, metric_id, sector_id', 'safe'
            ),
        );
    }


    public function relations()
    {
        return array(
            'sector' => array(
                self::BELONGS_TO, 'Sector', 'sector_id'
            ),
            'metric' => array(
                self::BELONGS_TO, 'Metric', 'metric_id'
            ),
        );
    }



}