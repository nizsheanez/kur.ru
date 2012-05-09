<?php

class ScopesBehavior extends CActiveRecordBehavior
{
    public function last()
    {
        $alias = $this->owner->getTableAlias();
        $this->owner
            ->getDbCriteria()
            ->mergeWith(array(
            'order' => $alias.'.date DESC',
        ));

        return $this->owner;
    }


    public function published()
    {
        $alias = $this->owner->getTableAlias();
        $this->owner
            ->getDbCriteria()
            ->addCondition($alias.'.is_published = 1');
        return $this->owner;
    }


    public function ordered()
    {
        $alias = $this->owner->getTableAlias();
        $this->owner
            ->getDbCriteria()
            ->mergeWith(array(
            'order' => $alias.'.`order`',
        ));

        return $this->owner;
    }


    public function limit($num)
    {
        $this->owner
            ->getDbCriteria()
            ->mergeWith(array(
            'limit' => $num,
        ));

        return $this->owner;
    }


    public function offset($num)
    {
        $this->owner
            ->getDbCriteria()
            ->mergeWith(array(
            'offset' => $num,
        ));

        return $this->owner;
    }

    public function in($row, $values, $operator = 'AND')
    {
        $this->owner
            ->getDbCriteria()
            ->addInCondition($row, $values, $operator);
        return $this->owner;
    }

    public function notIn($row, $values, $operator = 'AND')
    {
        $this->owner
            ->getDbCriteria()
            ->addNotInCondition($row, $values, $operator);
        return $this->owner;
    }


    public function notEqual($param, $value)
    {
        $this->owner
            ->getDbCriteria()
            ->mergeWith(array(
            'condition' => "`{$param}` != '{$value}'",
        ));

        return $this->owner;
    }
}
