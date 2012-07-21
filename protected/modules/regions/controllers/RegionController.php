<?php

class RegionController extends BaseController {

    public $layout = 'gmap';


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
}


