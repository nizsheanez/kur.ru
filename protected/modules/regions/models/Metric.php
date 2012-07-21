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
                'title, name, type, formula, min, norma, max', 'safe'
            ),
        );
    }

    public function inSubtreeOf($metric)
    {
        return $this->name == $metric;
    }
}