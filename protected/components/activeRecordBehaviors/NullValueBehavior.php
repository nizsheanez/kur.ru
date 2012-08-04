<?

class NullValueBehavior extends ActiveRecordBehavior
{
    public function beforeSave($event)
    {
        $model = $this->getOwner();

        $columns = Yii::app()->db->getSchema()->getTable($model->tableName())->columns;

        foreach ($model->attributes as $name => $value)
        {
            if ($value !== 0 && $value !== '0' && !$value && $columns[$name]->allowNull)
            {
                $model->$name = null;
            }
        }
    }
}
