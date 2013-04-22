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
    protected $mapper = array();
    /**
     * the primary key column
     * @var string
     */
    protected $primary = '';
    /**
     * 
     * @return string
     */
    public function getPrimary()
    {
        return $this->primary;
    }
    /**
     * 
     * @param string $primary
     * @return \Db_Mapper
     */
    public function setPrimary($primary)
    {
        $this->primary = (string)$primary;
        return $this;
    }
    /**
     * 
     * @return array
     */
    public function getMapper()
    {
        return $this->mapper;
    }
    /**
     * 
     * @param array $mapper
     * @return \Db_Mapper
     */
    public function setMapper(array $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
}
