<?php
class DataObjects_ItemRoot
{
    /**
     *
     * @var DataObjects_Item
     */
    protected $_root = null;

    public function __construct()
    {
        $root = new DataObjects_Item();
        $this->setRoot($root);
    }

    /**
     * @return DataObjects_Item
     */
    public function getRoot()
    {
        return $this->_root;
    }

    /**
     * @param DataObjects_Item $_root
     * @return DataObjects_ItemRoot
     */
    public function setRoot($_root)
    {
        $this->_root = $_root;
        return $this;
    }

    public function asJson()
    {
        return json_encode($this->getRoot()->asStdClass());
    }

}