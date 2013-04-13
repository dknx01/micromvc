<?php
/**
 * the table class
 * @author dknx01
 * @package Db
 */
class Db_Table
{
    /**
     *
     * @var PDO
     */
    protected $_connection = null;
    /**
     * table name
     * @var string
     */
    protected $_name = '';
    /**
     * the table model used for this dml class
     * @var Db_Model
     */
    protected $_modell = null;
    /**
     * the table mapper used for this dml class
     * @var Db_Mapper
     */
    protected $_mapper = null;

    public function __construct()
    {
        $this->_connection = Registry::getInstance()->get('db');
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
        $this->_modell = new $modelName;
        $this->_mapper = new $mapperName;
        
        if (!$this->_modell instanceof Db_Model) {
            throw new Exception($modelName . ' is not an instance of Db_Modell');
            exit;
        }
        if (!$this->_mapper instanceof Db_Mapper) {
            throw new Exception($mapperName . ' is not an instance of Db_Mapper');
            exit;
        }
    }
    /**
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
    /**
     * 
     * @param string $name
     * @return \Db_Dml
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }
    /**
     * maps a row to a table model
     * @param array $row
     * @return Db_Model
     * @throws Exception
     */
    public function mapper(array $row)
    {
        if (count($this->_mapper->getMapper()) == 0) {
            throw new Exception('Cannot use mapper because it\'s not declared');
        } else {
            $model = clone $this->_modell;
            foreach ($this->_mapper->getMapper() as $column => $property) {
                $setter = 'set' . ucfirst($property);
                $model->$setter($row[$column]);
            }
            return $model;
        }
    }
    /**
     * maps a table model to a table row
     * @param array $row
     * @return Db_Model
     * @throws Exception
     */
    public function reverseMapper($model)
    {
        if (count($this->_mapper->getMapper()) == 0) {
            throw new Exception('Cannot use mapper because it\'s not declared');
        } elseif(!$model instanceof Db_Model) {
            throw new Exception('Model does not base on Db_Model');
        }
        else {
            $row = array();
            foreach (array_flip($this->_mapper->getMapper()) as $property => $column) {
                $getter = 'get' . ucfirst($property);
                $row[$column] = $model->$getter();
            }
            return $row;
        }
    }
    /**
     * fetch all recors from this table
     * @return array
     * @throws Exception
     */
    public function fetchAll()
    {
        $sql = 'SELECT * FROM `' . $this->getName() . '`';
        $result = array();
        try {
            foreach ($this->_connection->exec($sql) as $row) {
                $result[] = $this->mapper($row);
            }
        } catch (PDOException $exc) {
            throw new Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
        }
        return $result;
    }
    public function insert($model)
    {
        $row = $this->reverseMapper($model);
        $sql = 'INSERT INTO `' . $this->getName() . '` SET ';
        foreach ($row as $column => $value) {
            $sql .= '`' . $column . '` = ' . $this->_connection->quote($value) . ',';
        }
        $sql = substr($sql, -1);
        try {
            $this->_connection->query($sql);
        } catch (PDOException $exc) {
            throw new Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
        }
    }
}