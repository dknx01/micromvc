<?php

Class View_Output
{
    /**
     *
     * @var string
     */
    private $layout = 'Layout';
    /**
     *
     * @var string
     */
    private $header = null;
    /**
     *
     * @var string
     */
    private $view = 'Index';
    /**
     *
     * @var string
     */
    private $footer = null;
    /**
     *
     * @var Helper_Request
     */
    private $request = null;
    /**
     *
     * @var stdClass
     */
    private $viewData = null;
    /**
     *
     * @var boolean
     */
    private $ajax = false;
    /**
     *
     * @var Config_Definition_Config
     */
    protected $config = null;

    public function __construct()
    {
        $this->viewData = new stdClass();
    }

    public function render()
    {
        $this->setView()
             ->setHeader()
             ->setFooter();
        
        ob_start();
        include_once $this->getView();
        $viewOutput = ob_get_contents();
        ob_end_clean();
        Registry::getInstance()->set('viewContent', $viewOutput);
        
        Helper_Debug::dump($viewOutput);exit;
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
            require_once APPDIR . '/Layout/Ajax.php';
            
        }
    }
    /**
     * 
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }
    /**
     * 
     * @param string $layout
     * @return \View_Render
     */
    public function setLayout($layout = null)
    {
        $layout = is_null($layout) ? 'Layout' : $layout;
        $this->layout = APPDIR . '/Layout/' . $layout . '.php';
        return $this;
    }
    /**
     * 
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }
    /**
     * 
     * @param string $header
     * @return \View_Render
     */
    public function setHeader($header = null)
    {
        $header = is_null($header) ? $this->getRequest()->getBaseName() : $header;
        $this->header = APPDIR . 'View/' . $header . '.header.php';
        return $this;
    }
    /**
     * 
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }
    /**
     * 
     * @param string $view
     * @return \View_Render
     */
    public function setView($view = null)
    {
        $view = is_null($view) ? $this->getRequest()->getBaseName() : $view;
        $this->view = APPDIR . '/View/' . $view . '.php';
        return $this;
    }
    /**
     * 
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }
    /**
     * 
     * @param string $footer
     * @return \View_Render
     */
    public function setFooter($footer = null)
    {
        $footer = is_null($footer) ? $this->getRequest()->getBaseName() : $footer;
        $this->footer = APPDIR . '/View/' . $footer . '.footer.php';
        return $this;
    }
    /**
     * 
     * @return Helper_Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    /**
     * 
     * @param Helper_Request $request
     * @return \View_Render
     */
    public function setRequest(Helper_Request $request)
    {
        $this->request = $request;
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
    /**
     * 
     * @param stdClass $viewData
     * @return \View_Render
     */
    public function setViewData(stdClass $viewData)
    {
        $this->viewData = $viewData;
        return $this;
    }
    /**
     * 
     * @param boolean $ajax
     * @return boolean
     */
    public function isAjax($ajax = false)
    {
        $this->ajax = (boolean)$ajax;
        return $this->ajax;
    }
    /**
     * 
     * @return Config_Definition_Config
     */
    public function getConfig()
    {
        return $this->config;
    }
    /**
     * 
     * @param Config_Definition_Config $config
     * @return \View_Output
     */
    public function setConfig(Config_Definition_Config $config)
    {
        $this->config = $config;
        return $this;
    }


}