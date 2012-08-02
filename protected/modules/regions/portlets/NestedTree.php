<?php
class NestedTree extends Portlet
{
    public $model;
    public $sortable = false;
    public $id;

    private $defaultSoringSettings = array(
        'disableNesting'      => 'no-nest',
        'forcePlaceholderSize'=> true,
        'handle'              => '.drag',
        'helper'              => 'clone',
        'items'               => 'li',
        'maxLevels'           => 0,
        'opacity'             => .6,
        'placeholder'         => 'placeholder',
        'revert'              => 250,
        'tabSize'             => 25,
        'tolerance'           => 'pointer',
        'toleranceElement'    => '> div',
        'listType'            => 'ul',
        'forceHelperSize'     => true,
        'start'               => "js:function(event, ui)
        {
            ui.placeholder.height(ui.item.height());
        }",
        'update'                => "js:function(event, ui)
        {
            var data = $(this).nestedSortable('toArray');
            $.post('/regions/save/sortMetrics',
                {
                    tree:$.toJSON(data)
                },
                function(data)
                {
                    if (data.status == 'ok')
                    {
                        alert(3);
                    }
                },
                'json'
            );
        }",

    );
    public $sortingSettings = array();


    public function init()
    {
        parent::init();
        $this->initVars();
        $this->registerScripts();
    }


    public function initVars()
    {
        $this->sortingSettings = CMap::mergeArray($this->defaultSoringSettings, $this->sortingSettings);
    }


    public function registerScripts()
    {
        $plugins = $this->assets . '/';
        $cs      = Yii::app()->clientScript;

        if ($this->sortable)
        {
            $settings = CJavaScript::encode($this->sortingSettings);
            $cs->registerScriptFile($plugins . 'nestedSortable/nestedSortable.js')->registerCssFile(
                $plugins . 'nestedSortable/nestedSortable.css')
                ->registerScriptFile($plugins . 'toJson/toJson.js')
                ->registerScript(
                $this->id . 'NestedTreeSortable', "$('#{$this->id} > ul').nestedSortable({$settings})");
        }
    }


    public function renderContent()
    {
        $this->render('NestedTree', array(
            'tree' => $this->htmlTree
        ));
    }

    public function getHtmlTree()
    {
        $models = $this->model->model()->getRoot()->descendants()->findAll();

        $depth = 0;
        $res   = '';

        foreach ($models as $n=> $item)
        {
            if ($item->depth == $depth)
            {
                $res .= CHtml::closeTag('li') . "\n";
            }
            else if ($item->depth > $depth)
            {
                $res .= CHtml::openTag('ul', array('class' => 'depth_' . $item->depth)) . "\n";
            }
            else
            {
                $res .= CHtml::closeTag('li') . "\n";

                for ($i = $depth - $item->depth; $i; $i--)
                {
                    $res .= CHtml::closeTag('ul') . "\n";
                    $res .= CHtml::closeTag('li') . "\n";
                }
            }

            $res .= CHtml::openTag('li', array(
                'id'   => 'items_' . $item->id,
                'class'=> 'depth_' . $item->depth
            ));
            $res .= CHtml::tag('div', array(), CHtml::encode($item->title) .
                '<img class="drag" src="/img/admin/hand.png" height="16" width="16" />');
            $depth = $item->depth;
        }

        for ($i = $depth; $i; $i--)
        {
            $res .= CHtml::closeTag('li') . "\n";
            $res .= CHtml::closeTag('ul') . "\n";
        }

        return $res;
    }
}