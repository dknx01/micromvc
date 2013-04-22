<?php

class Db_TestModel extends Db_Model
{
    protected $id;
    protected $testName;
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getTestName()
    {
        return $this->testName;
    }

    public function setTestName($testName)
    {
        $this->testName = $testName;
        return $this;
    }


}