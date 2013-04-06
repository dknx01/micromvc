<?php
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
     * @var Lib_Definition_Config
     */
    protected $_config = null;

    public function __construct()
    {
        $this->_request = new Helper_Request();
        $config = new Lib_ParseConfig();
        $this->_config = $config->getConfigData();
        $this->setController($this->getRequest()->getBaseName())
             ->setView()
             ->setViewHeader()
             ->_prepareDatabase();
        Registry::getInstance()->set('request', $this->getRequest());
        
       

    }
    public function run()
    {
        try {

            $controller = $this->getController();
            /**
             * @var Controller_Abstract
             */
            $controller = new $controller;
            $this->_viewData = $controller->getView();
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
            require_once realpath(__DIR__) . '/Layout/Layout.php';
            if (!is_null(Registry::getInstance()->get('db'))) {
                mysql_close(Registry::getInstance()->get('db'));
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage() . PHP_EOL . $e->getTraceAsString());
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
     * @return Application
     */
    public function setView()
    {
        $view =realpath(__DIR__) . '/View/' . $this->getRequest()->getBaseName()
                . '.php';
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
        $viewHeader = realpath(__DIR__) . '/View/' . 
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
        $host = $this->_config->getDatabaseHost();
        $user = $this->_config->getDatabaseUser();
        $status = $this->_config->getDatabaseStatus();
        $password = $this->_config->getDatabasePassword();
        $db = $this->_config->getDatabaseName();
        $params = $this->_config->getDatabaseParams();
        if ($status == true) {
            $dbConnection = mysql_connect($host, $user, $password);
            if (!$dbConnection) {
                throw new Exception('DB Connection Error: ' .  mysql_error());
            } else {
                if (!empty($params->charset)) {
                    mysql_set_charset((string)$params->charse, $dbConnection);
                }
                mysql_select_db($db, $dbConnection);
                Registry::getInstance()->set('db', $dbConnection);
            }
        }
        return $this;
    }
}