<?php

class DiplModule extends WebModule
{
    public static function name()
    {
        return 'Дипломчик';
    }


    public static function description()
    {
        return 'Дипломчик';
    }


    public static function version()
    {
        return '1.0';
    }


    public function init()
    {
        $this->setImport(array(
            'dipl.models.*', 'dipl.components.*',
        ));
    }
}
