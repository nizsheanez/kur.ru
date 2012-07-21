<?php

class RegionsModule extends WebModule
{
    public static function name()
    {
        return 'Статистика по регионам';
    }


    public static function description()
    {
        return 'Статистика по регионам';
    }


    public static function version()
    {
        return '1.0';
    }


    public function init()
    {
        $this->setImport(array(
            'regions.models.*', 'regions.components.*',
        ));
    }
}
