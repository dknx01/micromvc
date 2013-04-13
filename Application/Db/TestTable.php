<?php

class Db_TestTable extends Db_Table
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