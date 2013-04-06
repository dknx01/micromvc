<?php
class Controller_Abstract
{
    protected $_view = null;
    /**
     *
     * @var Helper_Request
     */
    protected $_request = null;
    public function __construct()
    {
        $this->_view = new stdClass();
        $this->_request = Registry::getInstance()->get('request');
        $this->run();
    }

    public function run()
    {
        $this->main();
    }

    public function main()
    {
    }
    /**
     * @return stdClass
     */
    public function getView()
    {
        return $this->_view;
    }

    /**
     * @param stdClass $_view
     * @return Controller_Abstract
     */
    public function setView($_view)
    {
        $this->_view = $_view;
        return $this;
    }
    /**
     *
     * @param string $name
     * @param mixed $value
     * @return Controller_Abstract
     */
    public function addToView($name, $value)
    {
        $this->_view->$name = $value;
        return $this;
    }
    /**
     * @return Helper_Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

}