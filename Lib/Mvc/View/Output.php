<?php
/**
 * procces the output passed to the browser
 * @author dknx01
 * @package View
 */
Class View_Output
{
    /**
     * the layout file name
     * @var string
     */
    private $layout = 'Layout';
    /**
     * the header file name
     * @var string
     */
    private $header = null;
    /**
     * the view file name
     * @var string
     */
    private $view = 'Index';
    /**
     * the footer file name
     * @var string
     */
    private $footer = null;
    /**
     * the request object
     * @var Helper_Request
     */
    private $request = null;
    /**
     * the data passed to the view
     * @var stdClass
     */
    private $viewData = null;
    /**
     * is this an ajax file
     * @var boolean
     */
    private $ajax = false;
    /**
     * the loaded and parsed configuration
     * @var Config_Definition_Config
     */
    protected $config = null;
    /**
     * the constructor
     * @param Helper_Request $request
     */
    public function __construct(Helper_Request $request)
    {
        $this->viewData = new stdClass();
        $this->setRequest($request);
        $this->setView()
             ->setHeader()
             ->setFooter();
    }
    /**
     * the a complete output
     */
    public function render()
    {        
        ob_start();
        include_once $this->getView();
        $viewOutput = ob_get_contents();
        ob_end_clean();
        Registry::getInstance()->set('viewContent', $viewOutput);
        
        if (file_exists($this->getHeader())) {
            ob_start();
            include_once $this->getHeader();
            $viewOutputHeader = ob_get_contents();
            ob_end_clean();
            Registry::getInstance()->set('viewHeader', $viewOutputHeader);
        }
        if (file_exists($this->getFooter())) {
            ob_start();
            include_once $this->getFooter();
            $viewOutputHeader = ob_get_contents();
            ob_end_clean();
            Registry::getInstance()->set('viewHeader', $viewOutputHeader);
        }
        if ($this->isAjax() == false) {
            require_once $this->getLayout();
        } else {
            require_once APPDIR . '/Layout/Ajax.phtml';
            
        }
    }
    /**
     *  get the current layout
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }
    /**
     * set a new layout
     * @param string $layout
     * @return \View_Render
     */
    public function setLayout($layout = null)
    {
        $layout = is_null($layout) ? 'Layout' : $layout;
        $this->layout = APPDIR . '/Layout/' . $layout . '.phtml';
        return $this;
    }
    /**
     * get the current header
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }
    /**
     * set a new header
     * @param string $header
     * @return \View_Render
     */
    public function setHeader($header = null)
    {
        $header = is_null($header) ? $this->getRequest()->getControllerName() : $header;
        $this->header = APPDIR . 'View/' . $header . '.header.phtml';
        return $this;
    }
    /**
     * get the current view
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }
    /**
     * set a new view
     * @param string $view
     * @return \View_Render
     */
    public function setView($view = null)
    {
        $view = is_null($view) 
                ? $this->getRequest()->getControllerName() . '/' . ucfirst($this->getRequest()->getAction())
                : $view;
        $this->view = APPDIR . '/View/' . $view . '.phtml';
        return $this;
    }
    /**
     * get the current footer
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }
    /**
     * set a new footer
     * @param string $footer
     * @return \View_Render
     */
    public function setFooter($footer = null)
    {
        $footer = is_null($footer) ? $this->getRequest()->getControllerName() : $footer;
        $this->footer = APPDIR . '/View/' . $footer . '.footer.phtml';
        return $this;
    }
    /**
     * get the request object
     * @return Helper_Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    /**
     * set a new request object
     * @param Helper_Request $request
     * @return \View_Render
     */
    public function setRequest(Helper_Request $request)
    {
        $this->request = $request;
        return $this;
    }
    /**
     * set new view data object
     * @param stdClass $viewData
     * @return \View_Render
     */
    public function setViewData(stdClass $viewData)
    {
        $this->viewData = $viewData;
        return $this;
    }
    /**
     * get or set if it is an ajax view
     * @param boolean|null $ajax
     * @return boolean
     */
    public function isAjax($ajax = null)
    {
        if (!is_null($ajax)) {
            $this->ajax = (boolean)$ajax;
        }
        return $this->ajax;
    }
    /**
     *  get the configuration object
     * @return Config_Definition_Config
     */
    public function getConfig()
    {
        return $this->config;
    }
    /**
     * set the configuration object
     * @param Config_Definition_Config $config
     * @return \View_Output
     */
    public function setConfig(Config_Definition_Config $config)
    {
        $this->config = $config;
        return $this;
    }
    /**
     * returns the value for the key of the view data or null if it's not exists.
     * If no key is provided the whole view data stor will be returned.
     * @param string $key
     * @return null|mixed
     */
    public function getViewData($key = null)
    {
        if (is_null($key)) {
            return $this->viewData;
        } elseif (property_exists($this->viewData, $key)) {
            return $this->viewData->$key;
        } else {
            return null;
        }
    }
}