<?php
class SquareData extends ActiveRecordModel
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
                'title, value, type', 'safe'
            ),
        );
    }


    public function relations()
    {
        return array(
            'square' => array(
                self::BELONGS_TO, 'Square', 'square_id'
            ),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('show_in_index', $this->show_in_index);
        $criteria->order = 'order DESC';

        return new ActiveDataProvider(get_class($this), array(
            'criteria' => $criteria
        ));
    }
}