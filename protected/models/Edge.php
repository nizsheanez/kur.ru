<?php
class Edge extends ActiveRecordModel
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
        return 'edge';
    }


    public function name()
    {
        return 'Модель Edge';
    }


    public function rules()
    {
        return array(
            array(
                'source, target, edge', 'safe'
            ),
        );
    }


    public function relations()
    {
        return array(
            'target_node' => array(
                self::BELONGS_TO, 'Node', 'target'
            ),
            'source_node' => array(
                self::BELONGS_TO, 'Node', 'source'
            ),
        );
    }


    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(

        ));
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
        return array(//            'logo' => array('dir' => self::PHOTOS_DIR)
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