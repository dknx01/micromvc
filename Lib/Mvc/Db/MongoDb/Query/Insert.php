<?php
/**
 * Created by JetBrains PhpStorm.
 * User: erik
 * Date: 29.06.13
 * Time: 17:01
 * To change this template use File | Settings | File Templates.
 */

namespace Mvc\Db\MongoDb\Query;

use \Mvc\Db\MongoDb\Query\QueryAbstract as Query;

class Insert extends Query
{
    protected $inserts = array();

    public function __construct($collection, \Mvc\Di\ServiceLocator $sl)
    {
        $this->setCollection($collection);
        parent::__construct($sl);
    }

    /**
     * execute the insert with some data
     * @param array $data
     * @return array|bool
     */
    public function insert(array $data)
    {
        return $this->getConnection()->selectCollection($this->getDatabase(), $this->getCollection())->insert($data);
    }

    /**
     * execute the insert
     */
    public function execute()
    {
        $this->insert($this->inserts);
    }

    /***
     * add a field value pair to the insert data
     *
     * @param string $field
     * @param mixed $value
     * @return \Mvc\Db\MongoDb\Query\Insert
     */
    public function addInsertPair($field, $value = null)
    {
        $this->inserts[$field] = $value;
        return $this;
    }
}