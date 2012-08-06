<ul class="nav" id="navigation">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            По секторам
            <i class="caret"></i>
        </a>
        <ul class="dropdown-menu" data-type="polygons">
            <?php
            foreach (
                CHtml::listData(Metric::model()->findAll('t.type=1'), 'name', 'title') as $name => $title)
            {
                $link = CHtml::link($title, '#' . $name);
                echo CHtml::tag('li', array(), $link);
            }
            ?>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            По кварталам
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu" data-type="squares">
            <?php
            foreach (
                CHtml::listData(Metric::model()->findAll('t.type=2'), 'name', 'title') as $name => $title)
            {
                $link = CHtml::link($title, '#' . $name);
                echo CHtml::tag('li', array(), $link);
            }
            ?>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Настройки
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu settings">
            <?php
            $link = CHtml::link('Сортировка метрик', '/regions/save/nested.sort', array(
                'id' => 'metrics-sortable-toggle',
                'data-fancybox-type '=> "iframe",
                'class'=> "fancy",
            ));
            echo CHtml::tag('li', array(), $link);
            $link = CHtml::link('Добавление метрики', '#new_metric_modal', array(
                'data-toggle'=>"modal",
                'class' => 'no-hashe'
            ));
            echo CHtml::tag('li', array(), $link);
            ?>
        </ul>
    </li>
</ul>
<ul class="nav pull-right nav-right">
    <li>
        <b>Обозначения:</b>
    </li>
    <li>
        <span class="label label-success">Норма</span>
    </li>
    <li>
        <span class="label label-info">Избыток</span>
    </li>
    <li>
        <span class="label label-important">Недостаток</span>
    </li>
</ul>