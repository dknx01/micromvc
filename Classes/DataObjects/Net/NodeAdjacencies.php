<?php
class DataObjects_Net_NodeAdjacencies
{
    protected $_items = array();
    protected $_name = '';
    /**
     * @return the $_items
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * @param array $_items
     * @return DataObjects_Net_NodeAdjacencies
     */
    public function setItems($_items)
    {
        $this->_items = $_items;
        return $this;
    }

    /**
     *
     * @param DataObjects_Net_NodeItem $item
     * @return DataObjects_Net_NodeAdjacencies
     */
    public function addItem(DataObjects_Net_NodeItem $item)
    {
        $this->_items[] = $item;
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
     * @return DataObjects_Net_NodeAdjacencies
     */
    public function setName($_name)
    {
        $this->_name = $_name;
        return $this;
    }

    public function asStdClass()
    {
        $return = array();
        $return[] = $this->getName();
       foreach ($this->getItems() as $item) {
           if ($item instanceof DataObjects_Net_NodeItem && method_exists($item, 'asStdClass')) {
               if ($this->_isEmpty($item) == false) {
                   $return[] = $item->asStdClass();
               }
           }
       }
        return $return;
    }

    protected function _isEmpty(DataObjects_Net_NodeItem $item)
    {
        $from = $item->getNodeFrom();
        $to = $item->getNodeTo();
        $empty = (empty($from) && empty($to)) == false ? true : false;
        return $empty;
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