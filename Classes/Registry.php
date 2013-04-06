<?php
class Registry
{
    protected $_store = null;
    static private $_instance = null;

    /**
     *
     * @return Registry
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
     *
     * @param string $name
     * @throws Exception
     */
    public function get($name)
    {
        if (property_exists($this->_store, $name)) {
            return $this->_store->$name;
        } else {
            return null;
        }
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     * @return Registry
     */
    public function set($name, $value)
    {
        if (property_exists($this, $name)) {
           error_log( 'Entry ' .  $name . ' will be overwritten');
        }
        $this->_store->$name = $value;
        return $this;
    }

}