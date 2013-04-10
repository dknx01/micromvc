<?php

class Db_TestModel extends Db_Model
{
    protected $_id;
    protected $_testName;
    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getTestName()
    {
        return $this->_testName;
    }

    public function setTestName($testName)
    {
        $this->_testName = $testName;
        return $this;
    }


}