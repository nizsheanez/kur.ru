<?php
class SaveController extends BaseController {

    public static function actionsTitles()
    {
        return array(
        );
    }

    public function actionPolygons()
    {
        foreach ($_POST['polygons'] as $sectorId => $coordinates) {
            $sector = Sector::model()->findByPk($sectorId);
            if ($sector)
            {
                foreach ($sector->polygons as $polygon) {
                    $polygon->delete();
                }
            }
            else
            {
                $sector = new Sector();
                $sector->title = $_POST['title'];
                $sector->square_id = $_POST['square_id'];
                $sector->save();
            }
            foreach ($coordinates as $i => $latLng) {
                $polygon = new Polygon();
                $polygon->sector_id = $sector->id;
                $polygon->attributes = $latLng;
                $polygon->save();
            }
        }
    }

    public function actionMetric()
    {
        $model = Metric::model()->findByAttributes(array('name' => $_POST['metric']));
        if ($model) {
            $model->attributes = $_POST['data'];
            $model->save();
        }
    }

    public function actionData($id = null, $metric = null)
    {
        if (isset($_POST['data']))
        {
            foreach ($_POST['data'] as $id => $value)
            {
                $model = Data::model()->findByPk($id);
                $model->value = (float)$value;
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


