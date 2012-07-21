<?php

class IndexController extends BaseController {

    public $layout = 'gmap';

    public static function actionsTitles()
    {
        return array(
        );
    }


    public function actionIndex()
    {
        $this->render('index2');
    }
}


