<?php

class FileManagerBehavior extends CActiveRecordBehavior
{
    public function getFileManagerRelation($tag)
    {
        $model = $this->getOwner();
        return array(
            CActiveRecord::HAS_MANY,
            'FileManager',
            'object_id',
            'condition' => "{$tag}.model_id = '". get_class($model) ."' AND {$tag}.tag='images'",
            'order' => "{$tag}.order DESC"
        );
    }

    public function afterSave($event)
    {
        $model = $this->getOwner();
        if ($model->isNewRecord)
        {
            $files = FileManager::model()->findAllByAttributes(array(
                'object_id' => 'tmp_' . Yii::app()->user->id,
                'model_id'  => get_class($model)
            ));

            foreach ($files as $file)
            {
                $file->object_id = $model->id;
                $file->save();
            }
        }

        return parent::beforeSave($event);
    }


    public function beforeDelete($event)
    {
        $model = $this->getOwner();

        $files = FileManager::model()->findAllByAttributes(array(
            'model_id'  => get_class($model),
            'object_id' => $model->id
        ));

        foreach ($files as $file)
        {
            $file->delete();
        }

        return parent::beforeDelete($event);
    }
}
