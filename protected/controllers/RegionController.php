<?php

class RegionController extends BaseController {

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

    public function actionSave()
    {
        foreach ($_POST['polygons'] as $SectorId => $coordinates) {
            foreach (Sector::model()->findByPk($SectorId)->polygons as $polygon) {
                $polygon->delete();
            }
            foreach ($coordinates as $i => $latLng) {
                $polygon = new Polygon();
                $polygon->sector_id = $SectorId;
                $polygon->attributes = $latLng;
                $polygon->save();
            }
        }
    }

    public function actionSaveFormula()
    {
        $model = Metric::model()->findByAttributes(array('name' => $_POST['metric']));
        if ($model) {
            $model->formula = $_POST['formula'];
            $model->save();
        }
    }

    public function actionSaveData($id = null, $metric = null)
    {
        if (isset($_POST['data']))
        {
            foreach ($_POST['data'] as $id => $value)
            {
                $model = Data::model()->findByPk($id);
                $model->value = $value;
                $model->save();
            }
            echo Sector::getJson();
        }
        else
        {
            foreach (Sector::model()->findByPk($id)->data as $item)
            {
                if ($item->metric->inSubtreeOf($metric) || $item->metric->type == null)
                {
                    echo CHtml::label($item->metric->title, 'data['.$item->id.']');
                    echo '<br />';
                    echo CHtml::textField('data['.$item->id.']', $item->value);
                    echo '<br />';
                }
            }
        }
    }
}


