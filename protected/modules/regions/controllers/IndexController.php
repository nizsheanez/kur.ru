<?php

class IndexController extends BaseController {

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


