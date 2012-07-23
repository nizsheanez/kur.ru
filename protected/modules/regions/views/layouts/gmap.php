<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=drawing,geometry,places"></script>
    <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble.js"></script>
    <?php
    $cs = Yii::app()->clientScript;
    Yii::app()->bootstrap->registerScripts();
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('jquery.ui');
    $cs->registerCoreScript('bbq');
    $cs->registerScriptFile('/js/fancybox/jquery.fancybox.js');
    $cs->registerCssFile('/js/fancybox/jquery.fancybox.css');
    $cs->registerCssFile(Yii::app()->assetManager->publish(
        Yii::getPathOfAlias('webroot.css.site.regions') . '.less'));
    ?>
</head>
<style>

    html, body, #map{
        width:   100%;
        height:  100%;
        margin:  0;
        padding: 0;
    }

</style>
<body>
<?= $content ?>
</body>
</html>