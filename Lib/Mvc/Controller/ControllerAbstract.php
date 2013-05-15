<?php
/**
 * the abstract controller class
 * @author dknx01
 * @package Mvc\Controller
 */

namespace Mvc\Controller;
use \Mvc\Registry as Registry;
use \stdClass;

abstract class ControllerAbstract
{
    /**
     * the view data
     * @var \stdClass
     */
    protected $viewData = null;
    /**
     * the request object
     * @var \Mvc\Helper\Request
     */
    protected $request = null;
    /**
     * the view name
     * @var string
     */
    protected $viewName = '';
    /**
     * is it an ajax view
     * @var boolean
     */
    protected $isAjax = false;
    /**
     * the layout name
     * @var string|null
     */
    protected $layout = null;
    /**
     * the constructor
     */
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
        $this->indexAction();
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
    abstract function indexAction();
    /**
     * adds an entry to the view
     * @param string $name
     * @param mixed $value
     * @return \Mvc\Controller\ControllerAbstract
     */
    public function addToView($name, $value)
    {
        $this->viewData->$name = $value;
        return $this;
    }
    /**
     * get the request helper object
     * @return \Mvc\Helper\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    /**
     * check if this is an ajax view request
     * @return boolean
     */
    public function isAjax()
    {
        return $this->isAjax;
    }
    /**
     * set if this is an ajax view request
     * @param boolean $_isAjax
     * @return \Mvc\Controller\ControllerAbstract
     */
    public function setIsAjax($_isAjax)
    {
        $this->isAjax = $_isAjax;
        return $this;
    }
    /**
     * get the view name for the controller
     * @return string
     */
    public function getViewName()
    {
        return $this->viewName;
    }
    /**
     * set the controllers view name
     * @param string $_viewName
     * @return \Mvc\Controller\ControllerAbstract
     */
    public function setViewName($_viewName)
    {
        $this->viewName = $_viewName;
        return $this;
    }
    /**
     * get all data used in the view
     * @return stdClass
     */
    public function getViewData()
    {
        return $this->viewData;
    }
    /**
     * the layout name
     * @return string|null
     */
    public function getLayout()
    {
        return $this->layout;
    }
    /**
     * set a new layout name
     * @param string $layout
     * @return \Mvc\Controller\ControllerAbstract
     */
    public function setLayout($layout)
    {
        $this->layout = empty($layout) ? null : $layout;
        return $this;
    }


}