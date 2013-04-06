<?php
class DataObjects_Item
{
    /**
     *
     * @var string
     */
    protected $_id = '';
    /**
     *
     * @var string
     */
    protected $_name = '';
    /**
     *
     * @var stdClass
     */
    protected $_data = null;
    /**
     *
     * @var array
     */
    protected $_children = array();
    /**
     * @return the $_id
     */

    public function __construct()
    {
        $this->_data = new stdClass();
    }
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param string $_id
     * @return DataObjects_Item
     */
    public function setId($_id)
    {
        $this->_id = $this->_normaliseId($_id);
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
     * @return DataObjects_Item
     */
    public function setName($_name)
    {
        $this->_name = $_name;

        if (empty($this->_id)) {
            $this->setId($_name);
        }
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
     * @return DataObjects_Item
     */
    public function setData($_data)
    {
        $this->_data = $_data;
        return $this;
    }

    /**
     * @return the $_children
     */
    public function getChildren()
    {
        return $this->_children;
    }

    /**
     * @param array $_children
     * @return DataObjects_Item
     */
    public function setChildren($_children)
    {
        $this->_children = $_children;
        return $this;
    }

    /**
     * @param DataObjects_Item $child
     * @return DataObjects_Item
     */
    public function addChild(DataObjects_Item $child)
    {
        $this->_children[] = $child;
        return $this;
    }

    protected function _normaliseId($id)
    {
        $id = strtolower($id);
        $id = str_replace(' ', '_', $id);
        return $id;
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