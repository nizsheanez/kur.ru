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
        <ul class="dropdown-menu" data-type="squares">
            <?php
            $link = CHtml::link('Сортировка метрик', '#', array('id' => 'metrics-sortable'));
            echo CHtml::tag('li', array(), $link);
            ?>
        </ul>
    </li>
</ul>