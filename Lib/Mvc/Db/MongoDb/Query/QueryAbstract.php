<?php
/**
 * the abstract class for our queries
 *
 * @author dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Db\MongoDb\Query;

use MongoCollection;

class QueryAbstract extends MongoCollection
{
    protected $database = 'test';
    protected $collection = 'test';
    /**
     * @var \MongoCollection
     */
    protected $selectedCollection = null;
    /**
     * @var \Mvc\Db\MongoDb\Adapter
     */
    protected $connection = null;


    public function __construct(\Mvc\Di\ServiceLocator $sl, $collection = null)
    {
        $this->connection = $sl->get('MongoDbAdapter');
        $this->setDatabase($this->getConnection()->getDbname());
        $this->db = $sl->get('db');
        if (!is_null($collection)) {
            parent::__construct($this->db, $collection);
        }
    }



    /**
     * @param string $collection
     *
     * @return \Mvc\Db\MongoDb\Query\QueryAbstract
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
        $this->setSelectedCollection($this->getConnection()->selectCollection($this->getDatabase(), $collection));
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

    /**
     * @param \MongoCollection $selectedCollection
     *
     * @return \Mvc\Db\MongoDb\Query\QueryAbstract
     */
    public function setSelectedCollection(\MongoCollection $selectedCollection)
    {
        $this->selectedCollection = $selectedCollection;
        return $this;
    }

    /**
     * @return \MongoCollection
     */
    public function getSelectedCollection()
    {
        return $this->selectedCollection;
    }
}