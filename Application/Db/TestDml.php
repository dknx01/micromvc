<?php

class Db_TestDml extends Db_Dml
{
    protected $_name = 'test';

    public function fetchAll()
    {
        $sql = 'Select * FROM `' . $this->getName();
        $return = array();
        foreach($this->_connection->query($sql) as $row){
            $return[] = $this->mapper($row);
        }
        return $return;
    }
}