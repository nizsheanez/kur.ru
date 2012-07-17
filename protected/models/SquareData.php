<?php
class SquareData extends ActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'square_data';
    }


    public function name()
    {
        return 'Модель SquareData';
    }


    public function rules()
    {
        return array(
            array(
                'value', 'safe'
            ),
        );
    }


    public function relations()
    {
        return array(
            'square' => array(
                self::BELONGS_TO, 'Square', 'square_id'
            ),
            'metric' => array(
                self::BELONGS_TO, 'Metric', 'metric_id'
            ),
        );
    }

}