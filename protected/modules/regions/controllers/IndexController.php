<?php

class IndexController extends Controller {

    public $layout = 'gmap';

    public function accessRules()
    {
        return array(
            array(
                'deny',
                'actions'=> array('*'),
                'users'  => array('?'),
            ),
            array(
                'allow',
                'actions'=> array('*'),
                'roles'  => array('admin'),
            ),
        );
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

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
