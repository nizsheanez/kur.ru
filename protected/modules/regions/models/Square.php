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
        return 'Модель Squares';
    }


    public function rules()
    {
        return array(
            array(
                'title', 'safe'
            ),
        );
    }


    public function relations()
    {
        return array(
            'sectors' => array(
                self::HAS_MANY, 'Sector', 'square_id'
            ),
        );
    }

}