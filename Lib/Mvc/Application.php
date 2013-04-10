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
    protected $_request = null;
    /**
     *
     * @var string
     */
    protected $_view = '';
    /**
     *
     * @var string
     */
    protected $_viewHeader = '';
    /**
     *
     * @var string
     */
    protected $_controller = '';
    /**
     *
     * @var mixed
     */
    protected $_viewData = null;
    
    /**
     *
     * @var Config_Definition_Config
     */
    protected $_config = null;
    /**
     * prepare the application
     */
    public function __construct()
    {
        $this->_request = new Helper_Request();
        $config = new Config_ParseConfig();
        $this->_config = $config->getConfigData();
        $this->setController($this->getRequest()->getBaseName())
             ->setView()
             ->setViewHeader()
             ->_prepareDatabase();
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
             * @var Application_Controller_Abstract
             */
            $controller = new $controllerName;
            $this->setViewData($controller->getView());
            $viewNameController = $controller->getViewName();
            if (!empty($viewNameController)) {
                $this->setView($viewNameController);
            }
            ob_start();
            include_once $this->getView();
            $viewOutput = ob_get_contents();
            ob_end_clean();
            Registry::getInstance()->set('viewContent', $viewOutput);

            if (file_exists($this->getViewHeader())) {
                ob_start();
                include_once $this->getViewHeader();
                $viewOutputHeader = ob_get_contents();
                ob_end_clean();
                Registry::getInstance()->set('viewHeader', $viewOutputHeader);
            }
            if ($controller->getIsAjax() == false) {
                require_once APPDIR . '/Layout/Layout.php';
            } else {
                require_once APPDIR . '/Layout/Ajax.php';
            }
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
        return $this->_request;
    }

    /**
     * @param Helper_Request $_request
     * @return Application
     */
    public function setRequest($_request)
    {
        $this->_request = $_request;
        return $this;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->_view;
    }

    /**
     * @param string $name
     * @return Application
     */
    public function setView($name = null)
    {
        if (!empty($name)) {
            $view = APPDIR . '/View/' . $name . '.php';
        } else {
            $view = APPDIR . '/View/' . $this->getRequest()->getBaseName() . '.php';
        }
        $this->_view = $view;
        return $this;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @param string $_controller
     * @return Application
     */
    public function setController($_controller)
    {
        $this->_controller = 'Controller_' . $_controller;
        return $this;
    }
    /**
     * 
     * @return string
     */
    public function getViewHeader()
    {
        return $this->_viewHeader;
    }
    /**
     * 
     * @return \Application
     */
    public function setViewHeader()
    {
        $viewHeader = APPDIR . 'View/' . 
                $this->getRequest()->getBaseName() . '.header.php';
        $this->_viewHeader = $viewHeader;
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
    protected function _prepareDatabase()
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