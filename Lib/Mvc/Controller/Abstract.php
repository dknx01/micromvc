<?php
/**
 * the abstract controller class
 * @author dknx01
 * @package Controller
 */
class Controller_Abstract
{
    /**
     *
     * @var stdClass
     */
    protected $_viewData = null;
    /**
     *
     * @var Helper_Request
     */
    protected $_request = null;
    /**
     *
     * @var string
     */
    protected $_viewName = '';
    /**
     *
     * @var boolean
     */
    protected $_isAjax = false;
    public function __construct()
    {
        $this->_viewData = new stdClass();
        $this->_request = Registry::getInstance()->get('request');
        $this->run();
    }

    /**
     * function to run the controllers and maybe do some preparing
     */
    public function run()
    {
        $this->up();
        $this->main();
    }
    /**
     * setup the current controller
     */
    public function up()
    {
    }

    /**
     * the main function
     */
    public function main()
    {
    }
    /**
     * @return stdClass
     */
    public function getView()
    {
        return $this->_viewData;
    }

    /**
     * @param stdClass $_view
     * @return Controller_Abstract
     */
    public function setView($_view)
    {
        $this->_viewData = $_view;
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
        $this->_viewData->$name = $value;
        return $this;
    }
    /**
     * @return Helper_Request
     */
    public function getRequest()
    {
        return $this->_request;
    }
    /**
     * @return boolean
     */
    public function getIsAjax()
    {
        return $this->_isAjax;
    }
    /**
     * @param boolean $_isAjax
     * @return Controller_Abstract
     */
    public function setIsAjax($_isAjax)
    {
        $this->_isAjax = $_isAjax;
        return $this;
    }
    /**
     * @return string
     */
    public function getViewName()
    {
        return $this->_viewName;
    }
    /**
     * @param string $_viewName
     * @return Controller_Abstract
     */
    public function setViewName($_viewName)
    {
        $this->_viewName = $_viewName;
        return $this;
    }
}