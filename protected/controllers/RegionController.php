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
            $metricModel = Metric::model()->findByAttributes(array('name' => $metric));
            if ($metricModel->type == '1')
            {
                echo $this->renderPartial('dataForm', array('sector' => Sector::model()->findByPk($id), 'metric' => $metric));
            }
            elseif ($metricModel->type = '2')
            {
                foreach (Sector::model()->findByPk($id)->square->sectors as $sector)
                {
                    echo CHtml::tag('h3', array(), $sector->title);
                    echo $this->renderPartial('dataForm', array('sector' => $sector, 'metric' => $metric));
                }
            }
        }
    }
}


