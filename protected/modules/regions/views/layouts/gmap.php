<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=drawing,geometry,places"></script>
    <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble.js"></script>
    <script type="text/javascript" src="/js/d3/d3.v2.js"></script>
    <?php
    $cs = Yii::app()->clientScript;
    Yii::app()->bootstrap->registerScripts();
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');
    $cs->registerCoreScript('bbq');
    $cs->registerScriptFile('/js/geoJson.js');
    $cs->registerScriptFile('/js/changeColor.js');
    $cs->registerScriptFile('/js/lib.js');
    $cs->registerScriptFile('/js/tooltip.js');
    $cs->registerCssFile(Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('webroot.css.site.regions') . '.less'));

    ?>
</head>
<body>
    <?= $content ?>
</body>
</html>