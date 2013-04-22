<?php
/**
 * the main class for all the mvc application
 * @author dknx01
 * @package Mvc
 */
class Application
{
    /**
     *
     * @var Helper_Request
     */
    protected $request = null;
    /**
     *
     * @var string
     */
    protected $view = '';
    /**
     *
     * @var string
     */
    protected $viewHeader = '';
    /**
     *
     * @var string
     */
    protected $controller = '';
    
    
    /**
     *
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
            $this->setViewData($controller->getView());
            $viewNameController = $controller->getViewName();
            $viewOutput = new View_Output();
            $viewOutput->setViewData($controller->getViewData())
                       ->setRequest($this->getRequest())
                       ->setConfig($this->config)
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
     * @return Helper_Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Helper_Request $_request
     * @return Application
     */
    public function setRequest($_request)
    {
        $this->request = $_request;
        return $this;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $_controller
     * @return Application
     */
    public function setController($_controller)
    {
        $this->controller = 'Controller_' . $_controller;
        return $this;
    }
    /**
     * 
     * @return mixed
     */
    public function getViewData()
    {
        return $this->_viewData;
    }
    /**
     * 
     * @param mixed $viewData
     * @return \Application
     */
    public function setViewData($viewData)
    {
        $this->_viewData = $viewData;
        return $this;
    }
    /**
     * 
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