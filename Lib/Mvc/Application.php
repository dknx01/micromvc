<?php
/**
 * the main class for all the mvc application
 * @author dknx01
 * @package Mvc
 */
class Application
{
    /**
     * request handler
     * @var Helper_Request
     */
    protected $request = null;
    /**
     * name of the controller
     * @var string
     */
    protected $controller = '';
    
    
    /**
     * the loaded and parsed config file
     * @var Config_Definition_Config
     */
    protected $config = null;
    /**
     * prepare the application
     */
    public function __construct()
    {
        $this->request = new Helper_Request();
        $config = new Config_ParseConfig();
        $this->config = $config->getConfigData();
        $this->setController($this->getRequest()->getBaseName())
             ->prepareDatabase();
        Registry::getInstance()->set('request', $this->getRequest());
    }
    /**
     * run the application
     */
    public function run()
    {
        try {
            $controllerName = $this->getController();
            /**
             * @var Controller_Abstract
             */
            $controller = new $controllerName;
            $viewNameController = $controller->getViewName();
            $viewOutput = new View_Output($this->getRequest());
            $viewOutput->setViewData($controller->getViewData())
                       ->setConfig($this->config)
                       ->setLayout()
                       ->isAjax($controller->isAjax());
            if (!empty($viewNameController)) {
                $viewOutput->setView($viewNameController);
            }
            $viewOutput->render();
            if (!is_null(Registry::getInstance()->get('db'))) {
                Registry::getInstance()->set('db', null);
            }
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
        $this->controller = 'Controller_' . $_controller;
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
            $db = new Db_Adapter();
            Registry::getInstance()->set('db', $db);
        } catch (PDOException $exc) {
            throw new Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
        }
        return $this;
    }
}