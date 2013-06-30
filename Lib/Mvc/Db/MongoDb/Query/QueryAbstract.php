<?php
/**
 * the abstract class for our queries
 *
 * @author dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Db\MongoDb\Query;


class QueryAbstract
{
    protected $database = 'test';
    protected $collection = 'test';
    /**
     * @var \Mvc\Db\MongoDb\Adapter
     */
    protected $connection = null;

    public function __construct(\Mvc\Di\ServiceLocator $sl)
    {
        $this->connection = $sl->get('db');
    }



    /**
     * @param string $collection
     *
     * @return \Mvc\Db\MongoDb\Query\QueryAbstract
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * @return string
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param \Mvc\Db\MongoDb\Adapter $connection
     *
     * @return \Mvc\Db\MongoDb\Query\QueryAbstract
     */
    public function setConnection(\Mvc\Db\MongoDb\Adapter $connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @return \Mvc\Db\MongoDb\Adapter
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param string $database
     *
     * @return \Mvc\Db\MongoDb\Query\QueryAbstract
     */
    public function setDatabase($database)
    {
        $this->database = $database;
        return $this;
    }

    /**
     * @return \Mvc\Db\MongoDb\Adapter
     */
    public function getDatabase()
    {
        return $this->database;
    }

}