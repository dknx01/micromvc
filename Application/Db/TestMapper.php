<?php
class Db_TestMapper extends Db_Mapper
{
    public function __construct()
    {
        $mapper = array(
            'id' => 'id',
            'name' => 'testName'
        );
        $this->setMapper($mapper)
             ->getPrimary('id');
    }
}
