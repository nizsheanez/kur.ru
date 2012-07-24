<?php

class IndexController extends Controller {

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


