<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <ul class="nav" id="navigation">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        По кварталам
                        <b class="caret" ></b>
                    </a>
                    <ul class="dropdown-menu">
                    <?php
                    foreach (CHtml::listData(Metric::model()->findAll('t.type=1'), 'name', 'title') as $name => $title)
                    {
                        $link = CHtml::link($title, '#' . $name);
                        echo CHtml::tag('li', array(), $link);
                    }
                    ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        По секторам
                        <i class="caret" ></i>
                    </a>
                    <ul class="dropdown-menu">
                    <?php
                    foreach (CHtml::listData(Metric::model()->findAll('t.type=2'), 'name', 'title') as $name => $title)
                    {
                        $link = CHtml::link($title, '#' . $name);
                        echo CHtml::tag('li', array(), $link);
                    }
                    ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php
//$form = new Form(array(
//    'action'               => '/region/saveMetric',
//    'activeForm'           => array(
//        'id'            => 'metric_form'
//    ),
//    'elements'             => array(
//        'formula'     => array(
//            'type' => 'text'
//        ),
//    ),
//    'buttons'              => array(
//        'submit' => array(
//            'type'  => 'submit',
//            'value' => 'сохранить',
//        )
//    )
//), new Metric());
//echo $form->toModalWindow('
//    <div id="edit_metric" style="z-index: 100; position: absolute; top: 70px; right: 10px;">
//        <a data-toggle="modal" href="#metric_form"><img src="/img/formula.png" width="32" height="32"/></a>
//    </div>', array(
//    'modalTitle' => 'Настройки метрики',
//    'callback' => 'function ($form, data) {
//            }'
//));
?>

<div class="modal hide" id="data_save_form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Редактирование сектора</h3>
    </div>
    <div class="modal-body">
        <form class="form-vertical">
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Отмена</a>
        <a href="#" id="data_save" class="btn btn-primary">Сохранить</a>
    </div>
</div>

<div class="modal hide" id="metric_form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Редактирование метрики</h3>
    </div>
    <div class="modal-body">
        <form class="form-vertical">
            <textarea id="formula" class="input-xlarge" rows="4" style="font: monospace;"></textarea>
        </form>
        <div style="">
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
<div style="z-index: 100; position: absolute; top: 100px; right: 10px; text-align: right">
    <div>
        <b>Обозначения:</b><br/>
        <span class="label label-success">Норма</span><br/>
        <span class="label label-info">Избыток</span><br/>
        <span class="label label-important">Недостаток</span>
    </div>
    <br/>
    <div id="edit_metric">
        <a data-toggle="modal" href="#metric_form"><img src="/img/formula.png" width="32" height="32"/></a>
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
