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
    protected $viewData = null;
    /**
     *
     * @var Helper_Request
     */
    protected $request = null;
    /**
     *
     * @var string
     */
    protected $viewName = '';
    /**
     *
     * @var boolean
     */
    protected $isAjax = false;
    public function __construct()
    {
        $this->viewData = new stdClass();
        $this->request = Registry::getInstance()->get('request');
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
        return $this->viewData;
    }

    /**
     * @param stdClass $_view
     * @return Controller_Abstract
     */
    public function setView($_view)
    {
        $this->viewData = $_view;
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
        $this->viewData->$name = $value;
        return $this;
    }
    /**
     * @return Helper_Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    /**
     * @return boolean
     */
    public function isAjax()
    {
        return $this->isAjax;
    }
    /**
     * @param boolean $_isAjax
     * @return Controller_Abstract
     */
    public function setIsAjax($_isAjax)
    {
        $this->isAjax = $_isAjax;
        return $this;
    }
    /**
     * @return string
     */
    public function getViewName()
    {
        return $this->viewName;
    }
    /**
     * @param string $_viewName
     * @return Controller_Abstract
     */
    public function setViewName($_viewName)
    {
        $this->viewName = $_viewName;
        return $this;
    }
    /**
     * 
     * @return stdClass
     */
    public function getViewData()
    {
        return $this->viewData;
    }
}