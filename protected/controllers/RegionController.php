<?php

class RegionController extends BaseController
{
    public $layout = '//layouts/gmap';

    public static function actionsTitles()
    {
        return array(
            "index"          => "Управление товарами",
            "save"          => "Управление товарами",
            "get"          => "Управление товарами",
        );
    }


    public function actionIndex()
    {
        $this->render('index2');
    }

    public function actionGet()
    {
        $res = array('type' => "FeatureCollection");
        foreach (Square::model()->findAll() as $square)
        {
            $tmp = array();
            $tmp['type'] = "Polygon";
            $tmp['properties'] = $square->properties;

            foreach ($square->polygons as $polygon)
            {
                $tmp['coordinates'][] = $polygon->coordinates;
            }
            $res['features'][] = $tmp;
        }
        echo CJSON::encode($res);
    }

    public function actionSave()
    {
        foreach($_POST['polygons'] as $squareId => $coordinates)
        {
            foreach (Square::model()->findByPk($squareId)->polygons as $polygon)
            {
                $polygon->delete();
            }
            foreach($coordinates as $i => $latLng)
            {
                $polygon = new Polygon();
                $polygon->square_id = $squareId;
                $polygon->attributes = $latLng;
                $polygon->save();
            }
        }
    }
}

