<?php
class DataObjects_Net_NodeItem
{
    protected $_nodeTo = '';
    protected $_nodeFrom = '';
    protected $_data = null;

    public function __construct()
    {
        $this->_data = new stdClass();
    }
    /**
     * @return the $_nodeTo
     */
    public function getNodeTo()
    {
        return $this->_nodeTo;
    }

    /**
     * @param string $_nodeTo
     * @return DataObjects_Net_NodeItem
     */
    public function setNodeTo($_nodeTo)
    {
        $this->_nodeTo = $_nodeTo;
        return $this;
    }

    /**
     * @return the $_nodeFrom
     */
    public function getNodeFrom()
    {
        return $this->_nodeFrom;
    }

    /**
     * @param string $_nodeFrom
     * @return DataObjects_Net_NodeItem
     */
    public function setNodeFrom($_nodeFrom)
    {
        $this->_nodeFrom = $_nodeFrom;
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
     * @param stdlass $_data
     * @return DataObjects_Net_NodeItem
     */
    public function setData($_data)
    {
        $this->_data = $_data;
        return $this;
    }
    /**
     *
     * @param string $name
     * @param string $value
     * @return DataObjects_Net_NodeItem
     */
    public function addDataEntry($name, $value)
    {
        $name = '$' . $name;
        $this->_data->$name = $value;
        return $this;
    }


    public function asStdClass()
    {
        $class = new stdClass();
        $properties = get_object_vars($this);
        foreach ($properties as $property => $value) {
            $property = substr($property, 1);
            $class->$property = $this->_getValue($value);
        }
        return $class;
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