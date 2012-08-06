<?php
class SaveController extends Controller
{

    public $layout = 'gmap';


    public static function actionsTitles()
    {
        return array();
    }

    public function actionPolygons()
    {
        $model = new Sector();
        $this->performAjaxValidation($model);

        foreach ($_POST['polygons'] as $sectorId => $coordinates)
        {
            $sector = Sector::model()->findByPk($sectorId);
            if ($sector)
            {
                foreach ($sector->polygons as $polygon)
                {
                    $polygon->delete();
                }
            }
            else
            {
                $sector             = new Sector();
                $sector->attributes = $_POST[get_class($sector)];
                $sector->save();
            }
            foreach ($coordinates as $i => $latLng)
            {
                $polygon             = new Polygon();
                $polygon->sector_id  = $sector->id;
                $polygon->attributes = $latLng;
                $polygon->save();
            }
        }
        if (!Yii::app()->request->isAjaxRequest)
        {
            $this->redirect('/regions/index/index');
        }
    }


    public function actionCreateMetric()
    {
        $model = new Metric('create');
        $this->performAjaxValidation($model);
        $form = new Form('regions.metric', $model);
        if ($form->submitted() && $model->appendTo(Metric::getRoot()))
        {
            //??? o_O
        }
        $this->redirect('/regions/index/index');
    }


    public function actionMetric()
    {
        $model = Metric::model()->findByAttributes(array('name' => $_POST['metric']));
        if ($model)
        {
            $model->attributes = $_POST['data'];
            $model->saveNode();
        }
    }


    public function actionDeleteMetric($id)
    {
        Metric::model()->findByPk($id)->deleteNode();
        $this->redirect('/regions/save/sortMetrics');
    }


    public function actionData($id = null, $metric = null)
    {
        if (isset($_POST['data']))
        {
            foreach ($_POST['data'] as $id => $value)
            {
                $model        = Data::model()->findByPk($id);
                $model->value = is_numeric($value) ? (int)$value : null;
                $model->save();
            }
            echo Sector::getJson();
        }
        else
        {
            $metricModel = Metric::model()->findByAttributes(array('name' => $metric));
            $metric_ids  = CHtml::listData($metricModel->getMetricWithDescendants(), 'id', 'id');
            if ($metricModel->type == '1')
            {
                echo $this->renderPartial('dataForm', array(
                    'sector'     => Sector::model()->findByPk($id),
                    'metric_ids' => $metric_ids
                ));
            }
            elseif ($metricModel->type = '2')
            {
                foreach (Sector::model()->findByPk($id)->square->sectors as $sector)
                {
                    echo CHtml::tag('h3', array(), $sector->title);
                    echo $this->renderPartial('dataForm', array(
                        'sector'     => $sector,
                        'metric_ids' => $metric_ids
                    ));
                    echo Chtml::hiddenField('sector_id', $id);
                }
            }
        }
    }


    public function actionDeleteSector($id)
    {
        Sector::model()->findByPk($id)->delete();
        $this->redirect('/regions/index/index');
    }


    public function actions()
    {
        return array(
            'nested.' => array(
                'class' => 'regions.portlets.NestedTree',
                'sort' => array(
                    'model' => Metric::model(),
                    'forwardRoute' => '/regions/index/actualData'
                ),
            )
        );
    }
}


