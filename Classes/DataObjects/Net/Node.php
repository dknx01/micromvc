<?php
class DataObjects_Net_Node
{
    protected $_adjacencies = array();
    protected $_data = null;
    protected $_name = '';
    protected $_id = '';

    public function __construct()
    {
        $this->_data = new stdClass();
    }
    /**
     * @return the $_adjacencies
     */
    public function getAdjacencies()
    {
        return $this->_adjacencies;
    }

    /**
     * @param array $_adjacencies
     * @return DataObjects_Net_Node
     */
    public function setAdjacencies(array $_adjacencies)
    {
        $this->_adjacencies = $_adjacencies;
        return $this;
    }
    /**
     *
     * @param DataObjects_Net_NodeAdjacencies $adjacency
     * @return DataObjects_Net_Node
     */
    public function addAdjacency(DataObjects_Net_NodeAdjacencies $adjacency)
    {
        $this->_adjacencies[] = $adjacency;
        return $this;
    }

    /**
     * @return the $_data
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @param stdClass $_data
     * @return DataObjects_Net_Node
     */
    public function setData($_data)
    {
        $this->_data = $_data;
        return $this;
    }

    public function addDataEntry($name, $value)
    {
        $name = '$' . $name;
        $this->_data->$name = $value;
        return $this;
    }

    /**
     * @return the $_name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $_name
     * @return DataObjects_Net_Node
     */
    public function setName($name)
    {
        $this->_name = $this->_normaliseName($name);
        if (empty($this->_id)) {
            $this->setId($this->_normaliseName($name));
        }
        return $this;
    }

    /**
     * @return the $_id
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param string $_id
     * @return DataObjects_Net_Node
     */
    public function setId($_id)
    {
        $this->_id = $_id;
        return $this;
    }

    protected function _normaliseName($name)
    {
        $id = strtolower($name);
        $id = str_replace(' ', '_', $name);
        return $name;
    }

    public function asStdClass()
    {
        $class = new stdClass();
        $properties = get_object_vars($this);
        foreach ($properties as $property => $value) {
            $property = substr($property, 1);
            $class->$property = $this->_getValue($value);
        }
        $class->adjacencies = $this->_cleanUpAdjacencies($class->adjacencies);
        return $class;
    }

    protected function _cleanUpAdjacencies(array $items)
    {
        $newArray = array();
        foreach ($items as $values) {
            foreach ($values as $entry) {
                $newArray[] = $entry;
            }
        }
        return $newArray;
    }
    protected function _getValue($data)
    {
        $newData = null;
        if (is_object($data) && method_exists($data, 'asStdClass')) {
            $newData = $data->asStdClass();
        } elseif (is_array($data)) {
            $newData = array();
            foreach ($data as $key => $value) {
                $newData[$key] = $this->_getValue($value);
            }
        } else {
            $newData = $data;
        }
        return $newData;
    }

}