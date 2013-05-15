<?php
/**
 * the main class for all the mvc application
 * @author dknx01
 * @package Mvc
 */
namespace Mvc;

use \Mvc\Helper as Helper;
use \Mvc\Config as Config;
use \Mvc\Db as Db;
use \Mvc\Registry as Registry;
use \Mvc\View as View;
use \Exception;

class Application
{
    /**
     * request handler
     * @var \Mvc\Helper\Request
     */
    protected $request = null;
    /**
     * name of the controller
     * @var string
     */
    protected $controller = '';
    /**
     * name of the action method
     * @var string 
     */
    protected $action = '';
    /**
     * the loaded and parsed config file
     * @var \Mvc\Config\Definition\Config
     */
    protected $config = null;
    /**
     * an instance of the view output
     * @var \Mvc\View\Output
     */
    protected $viewOutput = null;
    /**
     * prepare the application
     */
    public function __construct()
    {
        $this->request = new Helper\Request();
        $this->viewOutput = new View\Output($this->getRequest());
        $this->startUp();
    }
    /**
     * run the application
     */
    public function run()
    {
        try {
            $controllerName = $this->getController();
            /**
             * @var \Mvc\Controller\ControllerAbstract
             */
            $controller = new $controllerName();
            $actionMethod = $this->getAction();
            $controller->$actionMethod();
            $this->proccessOutput($controller);
            $this->shutDown();
        } catch (Exception $e) {
            throw new Exception($e->getMessage() . PHP_EOL 
                    . $e->getTraceAsString() . PHP_EOL);
        }

    }
    /**
     * return the request object
     * @return Helper_Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * set the request objec
     * @param Helper_Request $_request
     * @return Application
     */
    public function setRequest($_request)
    {
        $this->request = $_request;
        return $this;
    }

    /**
     * return the current controller name
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * set the controller name
     * @param string $_controller
     * @return Application
     */
    public function setController($_controller)
    {
        $this->controller = 'Application\Controller\\' . $_controller;
        return $this;
    }
    /**
     * prepare the database connection and store them in the registry
     * @return \Application
     * @throws Exception
     */
    protected function prepareDatabase()
    {
        try {
            $db = new Db\Adapter();
            Registry::getInstance()->set('db', $db);
        } catch (PDOException $exc) {
            throw new Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
        }
        return $this;
    }
    /**
     * 
     * @return typethe action method name
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * set the action method name
     * @param string $action
     * @return \Application
     */
    public function setAction($action)
    {
        $this->action = $action . 'Action';
        return $this;
    }
    /**
     * proccess and render the output
     * @param \Mvc\Controller\ControllerAbstract $controller
     */
    protected function proccessOutput(\Mvc\Controller\ControllerAbstract $controller)
    {
        $viewNameController = $controller->getViewName();
        $this->viewOutput->setViewData($controller->getViewData())
                   ->setConfig($this->config)
                   ->setLayout($controller->getLayout())
                   ->isAjax($controller->isAjax());
        if (!empty($viewNameController)) {
            $this->viewOutput->setView($viewNameController);
        }
        $this->viewOutput->render();
    }
    /**
     * the shutdown function for everything at the end
     */
    protected function shutDown()
    {
        if (!is_null(Registry::getInstance()->get('db'))) {
                Registry::getInstance()->set('db', null);
            }
    }
    /**
     * additional work before the rendering
     */
    protected function startUp()
    {
        if (file_exists(APPDIR . '/Config/Bootstrap.php')) {
            try {
                include_once APPDIR . '/Config/Bootstrap.php';
            } catch (Exception $exc) {
                throw new Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
            }
        }
        $config = new Config\ParseConfig();
        $this->config = $config->getConfigData();
        $this->setController($this->getRequest()->getControllerName())
              ->setAction($this->getRequest()->getAction())
             ->prepareDatabase();
        Registry::getInstance()->set('request', $this->getRequest());
    }
}