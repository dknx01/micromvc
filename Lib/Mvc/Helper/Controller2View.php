<?php
class Helper_Controller2View
{
    protected $_store = null;
    static private $_instance = null;

    /**
     *
     * @return Helper_Controller2View
     */
    static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        $this->_store = new stdClass();
    }

    /**
     * @return stdClass
     */
    public function getStore()
    {
        return $this->_store;
    }

    /**
     * @param stdClass $_store
     * @return Helper_Controller2View
     */
    public function setStore($_store)
    {
        $this->_store = $_store;
        return $this;
    }

}