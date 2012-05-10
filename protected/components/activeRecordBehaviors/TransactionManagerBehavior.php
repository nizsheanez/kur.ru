<?php
class TransactionManagerBehavior extends CActiveRecordBehavior
{
    private $_is_manager = false;
    private $_do_rollback = false;
    private $_do_commit = false;

    public function setIsTransactionManager($is_manager)
    {
        $this->_is_manager = $is_manager;
    }

    public function getIsTransactionManager()
    {
        return $this->_is_manager;
    }

    public function beforeSave()
    {
        if ($this->_is_manager && !Yii::app()->db->getCurrentTransaction())
        {
            $this->_do_rollback = $this->_do_commit = true;
            Yii::app()->db->beginTransaction();
        }
    }

    public function beforeDelete()
    {
        if ($this->_is_manager && !Yii::app()->db->getCurrentTransaction())
        {
            $this->_do_rollback = $this->_do_commit = true;
            Yii::app()->db->beginTransaction();
        }
    }

    public function afterSave()
    {
        if ($this->_do_commit)
        {
            Yii::app()->db->getCurrentTransaction()->commit();
            $this->reset();
        }
    }

    public function afterDelete()
    {
        if ($this->_do_commit)
        {
            Yii::app()->db->getCurrentTransaction()->commit();
            $this->reset();
        }
    }

    /**
     * @param CException $e
     */
    public function rollback($e)
    {
        if ($this->_is_manager && $this->_do_rollback)
        {
            Yii::app()->db->getCurrentTransaction()->rollback();
            Yii::app()->handleException($e);
        }

        $this->reset();
        throw $e;
        //            throw new CException($e->getMessage());
    }

    private function reset()
    {
        $this->_is_manager = $this->_do_rollback = $this->_do_commit = false;
    }


}
