<?php

class IndexController extends Controller {

    public $layout = 'gmap';

    public static function actionsTitles()
    {
        return array(
        );
    }


    public function actionActualData()
    {
        echo Sector::getJson();
    }

    public function actionIndex()
    {
        $this->render('index2');
    }
}
