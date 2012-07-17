<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <ul class="nav" id="navigation">
                <?php
                foreach (CHtml::listData(Metric::model()->findAll(), 'name', 'title') as $name => $title) {
                    $link = CHtml::link($title, '#' . $name);
                    echo CHtml::tag('li', array(), $link);
                }
                ?>
            </ul>
            <br/>
            <input id="formula" type="text" style="float:left; width: 91%; height: 10px; font-size: 10px; line-height: 10px; font: monospace;"/>
            <button id="formula_test" style="float: right; width: 4%; height: 21px;">Test</button>
            <button id="formula_save" style="float: right; width: 4%; height: 21px;">Save</button>
        </div>
    </div>
</div>
<div id="map"></div>
<style>
    .phoneytext {
        text-shadow: 0 -1px 0 #000;
        color: #fff;
        font-family: Helvetica Neue, Helvetica, arial;
        font-size: 12px;
        line-height: 14px;
        padding: 4px 45px 4px 15px;
        font-weight: bold;
    }

    .phoney {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0, rgb(112, 112, 112)), color-stop(0.51, rgb(94, 94, 94)), color-stop(0.52, rgb(57, 57, 57)));
        background: -moz-linear-gradient(center top, rgb(112, 112, 112) 0%, rgb(94, 94, 94) 51%, rgb(57, 57, 57) 52%);
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#map').metricMap({
            globalData: <?= Square::getJson() ?>
        });
    });
</script>
