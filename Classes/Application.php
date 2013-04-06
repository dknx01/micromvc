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
    protected $_controller = '';

    public function __construct()
    {
        $this->_request = new Helper_Request();
        $this->setController($this->getRequest()->getBaseName())
             ->setView($this->getRequest()->getBaseName());
        Registry::getInstance()->set('request', $this->getRequest());

        $asTree = (array_key_exists('asTree', $this->getRequest()->getParams()) && $this->getRequest()->getParamByName('asTree') == 'true')
                  ? true
                  : false;
        Registry::getInstance()->set('asTree', $asTree);
    }
    public function run()
    {
        try {
            $dbConnection = mysql_connect('10.143.1.11', 'kicker', 'kick');
            if (!$dbConnection) {
                throw new Exception('DB Connection Error: ' .  mysql_error(Registry::getInstance()->get('db')));
            } else {
                mysql_set_charset('UTF-8', $dbConnection);
                mysql_select_db('kicker', $dbConnection);
                Registry::getInstance()->set('db', $dbConnection);
            }
            $controller = $this->getController();
            /**
             * @var Controller_Abstract
             */
            $controller = new $controller;
            Helper_Controller2View::getInstance()->setStore($controller->getView());
            $view = $this->getView();
            $view = realpath(__DIR__) . '/' . str_replace('_', DIRECTORY_SEPARATOR, $view) . '.php';
            $viewHeader = realpath(__DIR__) . '/' . str_replace('_', DIRECTORY_SEPARATOR, $view) . '.header.php';
            $viewOutput = Helper_Output::getObjOutput($view);
            Registry::getInstance()->set('viewContent', $viewOutput);

            if (file_exists($viewHeader)) {
                $viewOutputHeader = Helper_Output::getObjOutput($viewHeader);
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
     * @param string $_view
     * @return Application
     */
    public function setView($_view)
    {
        $this->_view = 'View_' . $_view;
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

}