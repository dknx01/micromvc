<?php
/**
 * the table class
 * @author dknx01
 * @package Mvc\Db
 */

namespace Mvc\Db;
use \PDO as PDO;
use \Mvc\Db\Mapper as Mapper;
use \Mvc\Db\Model as Model;
use \Mvc\Registry as Registry;

class Table
{
    /**
     * the pdo connection
     * @var \PDO
     */
    protected $connection = null;
    /**
     * table name
     * @var string
     */
    protected $name = '';
    /**
     * the table model used for this dml class
     * @var \Mvc\Db\Model
     */
    protected $model = null;
    /**
     * the table mapper used for this dml class
     * @var \Mvc\Db\Mapper
     */
    protected $mapper = null;
    /**
     * the constructor
     * @throws Exception
     */
    public function __construct()
    {
        $this->connection = Registry::getInstance()->get('db');
        $modelName = str_replace('Table', 'Model', get_class($this));
        $mapperName = str_replace('Table', 'Mapper', get_class($this));
        if (!class_exists($modelName)) {
            throw new Exception('Model ' . $modelName . ' not found');
            exit;
        }
        if (!class_exists($mapperName)) {
            throw new Exception('Mapper ' . $mapperName . ' not found');
            exit;
        }
        $this->model = new $modelName;
        $this->mapper = new $mapperName;
        
        if (!$this->model instanceof Model) {
            throw new Exception($modelName . ' is not an instance of Db_Modell');
            exit;
        }
        if (!$this->mapper instanceof Mapper) {
            throw new Exception($mapperName . ' is not an instance of Db_Mapper');
            exit;
        }
    }
    /**
     * get the table name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * set the table name
     * @param string $name
     * @return \Mvc\Db\Table
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * maps a row to a table model
     * @param array $row
     * @return \Mvc\Db\Model
     * @throws Exception
     */
    public function mapper(array $row)
    {
        if (count($this->mapper->getMapper()) == 0) {
            throw new Exception('Cannot use mapper because it\'s not declared');
        } else {
            $model = clone $this->model;
            foreach ($this->mapper->getMapper() as $column => $property) {
                $setter = 'set' . ucfirst($property);
                $model->$setter($row[$column]);
            }
            return $model;
        }
    }
    /**
     * maps a table model to a table row
     * @param array $row
     * @return \Mvc\Db\Model
     * @throws Exception
     */
    public function reverseMapper($model)
    {
        if (count($this->mapper->getMapper()) == 0) {
            throw new Exception('Cannot use mapper because it\'s not declared');
        } elseif(!$model instanceof Db_Model) {
            throw new Exception('Model does not base on Db_Model');
        }
        else {
            $row = array();
            foreach (array_flip($this->mapper->getMapper()) as $property => $column) {
                $getter = 'get' . ucfirst($property);
                $row[$column] = $model->$getter();
            }
            return $row;
        }
    }
    /**
     * fetch all records from this table
     * @param boolean $asIterator should the result implements Db_ResultIterator
     * @return array with \Mvc\Db\Model instances for each row
     * @throws Exception
     */
    public function fetchAll($asIterator = false)
    {
        $sql = 'SELECT * FROM `' . $this->getName() . '`';
        $result = array();
        try {
            foreach ($this->connection->query($sql) as $row) {
                $result[] = $this->mapper($row);
            }
        } catch (PDOException $exc) {
            throw new Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
        }
        return $asIterator == true ? new Db_ResultIterator($result) : $result;
    }
    
    /**
     * Inserts a database model into a table without the primary column
     * @param \Mvc\Db\Model $model
     * @return null|int null if nothing was insert or lastInsertId
     * @throws Exception
     */
    public function insert($model)
    {
        $row = $this->reverseMapper($model);
        $insertId = null;
        $sql = 'INSERT INTO `' . $this->getName() . '` SET ';
        foreach ($row as $column => $value) {
            if ($column != $this->mapper->getPrimary()) {
                $sql .= '`' . $column . '` = ' . $this->connection->quote($value) . ',';
            }
        }
        $sql = substr($sql, -1);
        try {
            $this->connection->query($sql);
            $insertId = (int)$this->connection->lastInsertId();
        } catch (PDOException $exc) {
            throw new Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
        }
        return $insertId;
    }
    
    /**
     * fetches a record from this table identified by the primary key
     * @param mixed $id
     * @return false|\Mvc\Db\Model instances for a row
     * @throws Exception
     */
    public function fetchById($id = false)
    {
        $result = false;
        if ($id == false) {
            throw new Exception('Id must be set');
        }
        $sql = 'SELECT * FROM `' . $this->getName() . '` '
               . 'WHERE `' . $this->mapper->getPrimary() . '` = '
               . $this->connection->quote($id)
               . ' LIMIT 1';
        try {
            foreach ($this->connection->query($sql) as $row) {
                $result = $this->mapper($row);
            }
        } catch (PDOException $exc) {
            throw new Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
        }
        return $result;
    }
}