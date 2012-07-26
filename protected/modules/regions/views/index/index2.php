<?php
Yii::app()->clientScript->registerScriptFile('/js/lib.js');
?>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <? $this->renderPartial('_topMenu') ?>
        </div>
    </div>
</div>
<div class="modal hide" id="data_save_form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Редактирование сектора</h3>
    </div>
    <div class="modal-body">
        <form action="" class="form-vertical">
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Отмена</a>
        <a href="#" id="data_save" class="btn btn-primary">Сохранить</a>
    </div>
</div>
<div class="modal hide" id="metric_sortable_form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Сортировка метрик</h3>
    </div>
    <div class="modal-body">
        <form action="" class="form-vertical">
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Отмена</a>
        <a href="#" id="metric_sortable_save" class="btn btn-primary">Сохранить</a>
    </div>
</div>
<div class="modal hide" id="metric_form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Редактирование метрики</h3>
    </div>
    <div class="modal-body">
        <form class="form-vertical">
            Формула: <br/>
            <textarea id="metric_formula" class="input-xlarge" rows="4" style="font: monospace;"></textarea><br/>
            Минимум:<br/>
            <textarea id="metric_min" class="input-xlarge" rows="4" style="font: monospace;"></textarea><br/>
            Норма:<br/>
            <textarea id="metric_norma" class="input-xlarge" rows="4" style="font: monospace;"></textarea><br/>
            Максимум:<br/>
            <textarea id="metric_max" class="input-xlarge" rows="4" style="font: monospace;"></textarea><br/>
        </form>
        <div>
            <?php
            foreach (Metric::model()->findAll() as $item)
            {
                echo '<li>' . $item->title . ' - ' . $item->name . '</li>';
            }
            ?>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Отмена</a>
        <a href="#" id="formula_save" class="btn btn-primary">Сохранить</a>
    </div>
</div>
<div style="z-index: 100; position: absolute; top: 100px; right: 10px; text-align: right;" class="right-toolbar">
    <div id="edit_metric">
        <a data-toggle="modal" href="#metric_form"><img src="/img/formula.png" width="40" height="40"/></a>
    </div>
</div>
<div id="map"></div>
<style>
    .phoneytext{
        text-shadow: 0 -1px 0 #000;
        color:       #fff;
        font-family: Helvetica Neue, Helvetica, arial;
        font-size:   12px;
        line-height: 14px;
        padding:     4px 45px 4px 15px;
        font-weight: bold;
    }

    .phoney{
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0, rgb(112, 112, 112)), color-stop(0.51, rgb(94, 94, 94)), color-stop(0.52, rgb(57, 57, 57)));
        background: -moz-linear-gradient(center top, rgb(112, 112, 112) 0%, rgb(94, 94, 94) 51%, rgb(57, 57, 57) 52%);
    }
</style>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#map').metricMap({
            globalData: <?= Sector::getJson() ?>
        });
    });
</script>
