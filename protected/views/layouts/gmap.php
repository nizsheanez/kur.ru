<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=drawing,geometry,places"></script>
    <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble.js"></script>
    <script type="text/javascript" src="http://mbostock.github.com/d3/d3.js?1.29.1"></script>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/js/geoJson.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/js/changeColor.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/js/lib.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile('/js/tooltip.js'); ?>
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