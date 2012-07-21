<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
    $cs->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css.site.regions').'.less'));

    ?>
    <style type="text/css">

        html, body, #map{
            width:   100%;
            height:  100%;
            margin:  0;
            padding: 0;
        }

        .stations, .stations svg{
            position: absolute;
        }

        .stations svg{
            width:         60px;
            height:        20px;
            padding-right: 100px;
            font:          10px sans-serif;
        }

        .stations circle{
            fill:         brown;
            stroke:       black;
            stroke-width: 1.5px;
        }

    </style>
</head>
<body>
<?= $content ?>
</body>
</html>