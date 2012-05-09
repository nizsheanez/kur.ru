<?php
class Node extends ActiveRecordModel
{
    const PAGE_SIZE   = 10;
    const PHOTOS_DIR  = 'upload/producers';
    const LOGO_HEIGHT = 84;


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'node';
    }


    public function name()
    {
        return 'Модель Node';
    }


    public function rules()
    {
        return array(
            array(
                'title', 'safe'
            ), array(
                'id, title, show_in_index, logo, order', 'safe',
                'on' => 'search'
            ),
        );
    }


    public function relations()
    {
        $data = array('sinonim', 'associate', 'subclass_of', 'is_a', 'english');
        $res  = array();
        foreach ($data as $d)
        {
            $name            = $d . '_edges';
            $res[$name]      = array(
                self::HAS_MANY, 'Edge', 'source',
                'condition'=> $name . ".edge='{$d}'"
            );
            $name2           = $d . '_edges_in';
            $res[$name2]     = array(
                self::HAS_MANY, 'Edge', 'target',
                'condition'=> $name2 . ".edge='{$d}'"
            );
            $res[$d]         = array(
                self::HAS_MANY, 'Node', 'target',
                'through'  => $name,
                'condition'=> $name . ".edge='{$d}'"
            );
            $res[$d . '_in'] = array(
                self::HAS_MANY, 'Node', 'source',
                'through'  => $name2,
                'condition'=> $name2 . ".edge='{$d}'"
            );
        }
        return CMap::mergeArray($res, array(
            'edges'                          => array(self::HAS_MANY, 'Edge', 'source'),
            'in_edges'                       => array(self::HAS_MANY, 'Edge', 'target'),
            'target_nodes'                   => array(
                self::HAS_MANY, 'Node', 'target',
                'through'=> 'edges'
            ),
            'source_nodes'                   => array(
                self::HAS_MANY, 'Node', 'source',
                'through'=> 'in_edges'
            ),
        ));
    }

    public function getAllEdges()
    {
        $criteria = new CDbCriteria(array(
            'condition' => '(t.source='.$this->id.') or (t.target='.$this->id.')'
        ));
        $model = Edge::model();
        $model->getDbCriteria()->mergeWith($criteria);
        return $model->findAll();
    }

    public function getAttributes()
    {
        return array_merge(parent::getAttributes(), array(
            'alpha'=> 1,
            'color'=> "red"
        ));
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(),array(
            'withRelated'                  => array(
                'class'=> 'application.components.activeRecordBehaviors.WithRelatedBehavior',
            ),
        ));
    }

    public function autocomplete($term)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->compare("{$alias}.title", $term, true);
        return $this;
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('show_in_index', $this->show_in_index);
        $criteria->order = 'order DESC';

        return new ActiveDataProvider(get_class($this), array(
            'criteria' => $criteria
        ));
    }


    public static function getListData()
    {
        return CHtml::listData(self::model()->findAll(), 'id', 'title');
    }

    public function getEdgesCount()
    {
        return 'UPDATE node SET edges_count = (select count(*) from edge b where (b.source=node.id) or (b.target=node.id))';
    }

    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'hasImage' => array(
                'condition' => "$alias.logo!=NULL AND $alias.logo!=''"
            ),
            'ordered'  => array(
                'order' => "$alias.order DESC"
            )
        );
    }


    public function uploadFiles()
    {
        return array( //            'logo' => array('dir' => self::PHOTOS_DIR)
        );
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            return true;
        }
        return false;
    }


    public function beforeDelete()
    {
        if (parent::beforeSave())
        {
            return true;
        }
        return false;
    }
}