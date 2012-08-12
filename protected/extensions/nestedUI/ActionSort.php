<?php
class ActionSort extends CAction{

    public $model;
    public $forwardRoute;

    public function run()
    {
        $model = $this->model;
        $class = get_class($model);

        if (isset($_POST['tree']))
        {
            $this->controller->performAjaxValidation($model);

            //при сортировке дерева параметры корня измениться не могут,
            //поэтоtму его вообще сохранять не будем
            $data = json_decode($_POST['tree']);
            array_shift($data);

            //получаем большие case для update
            $update               = array();
            $nestedSortableFields = array(
                'depth'=> $class::DEPTH,
                'left' => $class::LFT,
                'right'=> $class::RGT
            );
            foreach ($nestedSortableFields as $key => $field)
            {
                $update_data = CHtml::listData($data, 'item_id', $key);
                if ($key == $class::DEPTH)
                {
                    foreach ($update_data as $key => $val)
                    {
                        $update_data[$key]++;
                    }
                }
                $update[] = "{$field} = " . SqlHelper::arrToCase('id', $update_data);
            }

            //обновляем всю таблицу, кроме рута
            $condition = $class::DEPTH . " > 1";
            $command   = Yii::app()->db->createCommand(
                "UPDATE `{$model->tableName()}` SET " . implode(', ', $update) . " WHERE {$condition}");
            $command->execute();
            $this->controller->forward($this->forwardRoute, true);
        }

        $this->controller->render('sort', array(
            'model'    => $model,
            'class'    => $class
        ));
    }
}