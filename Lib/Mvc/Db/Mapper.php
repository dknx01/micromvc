<?php
/**
 * the basic mapper class
 * @author dknx01
 * @package Db
 */
class Db_Mapper
{
    /**
     * the model db result mapper
     * @var array
     */
    protected $_mapper = array();
    /**
     * the primary key column
     * @var string
     */
    protected $_primary = '';
    /**
     * 
     * @return string
     */
    public function getPrimary()
    {
        return $this->_primary;
    }
    /**
     * 
     * @param string $primary
     * @return \Db_Mapper
     */
    public function setPrimary($primary)
    {
        $this->_primary = (string)$primary;
        return $this;
    }
    /**
     * 
     * @return array
     */
    public function getMapper()
    {
        return $this->_mapper;
    }
    /**
     * 
     * @param array $mapper
     * @return \Db_Mapper
     */
    public function setMapper(array $mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
}
