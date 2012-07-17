<?php

class RegionController extends BaseController
{
    public $layout = '//layouts/gmap';


    public static function actionsTitles()
    {
        return array(
            "index"          => "Управление товарами",
            "save"           => "Управление товарами",
            "get"            => "Управление товарами",
        );
    }


    public function actionIndex()
    {
        $this->render('index2');
    }


    public function actionAddData()
    {
        $model = new SquareData();

        $form = new Form(array(
            'activeForm' => array(
                'id' => 'data-form',
            ),
            'elements'   => array(
                'metric_id' => array('dropdown' => CHtml::listData(Metric::model()->findAll(), 'id', 'name')),
                'square_id' => array('dropdown' => CHtml::listData(Square::model()->findAll(), 'id', 'name')),
            ),
            'buttons'    => array(
                'submit' => array(
                    'type'  => 'submit',
                    'value' => $this->model->isNewRecord ? 'создать' : 'сохранить'
                )
            )
        ), $model);

        if ($form->submitted() && $model->metric_id && $model->square_id)
        {
            $this->redirect(array('addData2', 'metric_id' => $model->metric_id, 'square_id' => $model->square_id));
        }
        $this->render('addData', array('form' => $form));
    }

    public function actionAddData2($metric_id, $square_id)
    {
        $data = array('metric_id' => $metric_id, 'square_id' => $square_id);
        $model = SquareData::model()->findByAttributes($data);
        if (!$model)
        {
            $model = new SquareData();
            $model->attributes = $data;
        }

        $form = new Form(array(
            'activeForm' => array(
                'id' => 'data-form',
            ),
            'elements'   => array(
                'title' => array('type' => 'text')
            ),
            'buttons'    => array(
                'submit' => array(
                    'type'  => 'submit',
                    'value' => $this->model->isNewRecord ? 'создать' : 'сохранить'
                )
            )
        ), $model);
        if ($form->submitted())
        {
            $model->save();
        }
        $this->render('addData2', array('form' => $form));
    }


    public function actionSave()
    {
        foreach ($_POST['polygons'] as $squareId => $coordinates)
        {
            foreach (Square::model()->findByPk($squareId)->polygons as $polygon)
            {
                $polygon->delete();
            }
            foreach ($coordinates as $i => $latLng)
            {
                $polygon             = new Polygon();
                $polygon->square_id  = $squareId;
                $polygon->attributes = $latLng;
                $polygon->save();
            }
        }
    }

    public function actionSaveFormula()
    {
        $model = Metric::model()->findByAttributes(array('name' => $_POST['metric']));
        if ($model)
        {
            $model->formula = $_POST['formula'];
            $model->save();
        }
    }
}

