<?php
/**
 * helper class to procces the request and get the basename for the controller and all params
 * @author dknx01
 * @package Mvc\Helper
 */
namespace Mvc\Helper;

class Request
{
    /**
     * the value separator
     * @var string
     */
    const SEPARATOR = '/';
    /**
     * the controller name
     * @var string
     */
    protected $controllerName = 'Index';
    /**
     * name of the action
     * @var string
     */
    protected $action = 'index';
    /**
     * all passed params
     * @var array
     */
    protected $params = array();
    /**
     * the query string
     * @var string
     */
    private $queryString = '';
    /**
     * the constructor
     */
    public function __construct()
    {
        $this->queryString = '';
        if ($_SERVER['REQUEST_URI'] == '/') {
            $this->querystring = '';
        } else {
            $this->queryString = trim(substr($_SERVER['REQUEST_URI'], 1));
        }
        if (strlen($this->queryString) > 0) {
            $controllerEnd = strpos($this->queryString, self::SEPARATOR);
            if ($controllerEnd != false) {
                $this->controllerName = substr($this->queryString, 0, $controllerEnd);
                $this->queryString = substr($this->queryString, $controllerEnd + 1);
                $actionEnd = strpos($this->queryString, self::SEPARATOR);
                if ($actionEnd != false) {
                    $this->action = substr($this->queryString, 0, $actionEnd);
                    $this->queryString = substr($this->queryString, $actionEnd + 1);
                    $this->getAllParams();
                } else {
                    $this->action = $this->queryString;
                    $this->originRequestUri();
                    $this->getPostParamas();
                }
                
            } else {
                if (substr($this->queryString, 0, 1) == '?') {
                    $this->getAllParams();
                } else {
                    $this->controllerName = $this->queryString;
                    $this->originRequestUri();
                    $this->getPostParamas();
                }
            }
        }
    }
    /**
     * retrive all params get by GET or POST method
     */
    private function getAllParams()
    {
        $this->queryString = ltrim($this->queryString, '?');
        if (!empty($this->queryString)) {
            if (strpos($this->queryString, '/') != false) {
                $params = explode('/', $this->queryString);
            } else {
                $params = explode('&', $this->queryString);
            }         
            foreach ($params as $param) {
                $this->splitParam($param);
            }
            $this->originRequestUri();
        }
        $this->getPostParamas();
    }
    /**
     * splits the param string in key and value part
     * @param string $param
     * @param string $delimiter default '='
     */
    private function splitParam($param, $delimiter = '=')
    {
        $parts = explode($delimiter, $param);
        $this->params[$parts[0]] = $parts[1];
    }

    /**
     * proccess all post params
     */
    private function getPostParamas()
    {
        foreach ($_POST as $key => $value) {
            $this->params[$key] = $value;
        }
    }
    private function originRequestUri()
    {
        $this->queryString = $_SERVER['REQUEST_URI'];
    }

    /**
     * the controller name
     * @return string
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * set an new basename
     * @param string $controllerName
     * @return \Mvc\Helper\Request
     */
    public function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
        return $this;
    }

    /**
     * all passed params
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * get a param by its name
     * @param string $_params
     * @return string | null
     */
    public function getParamByName($name)
    {
        return (array_key_exists($name, $this->params) == true) ? $this->params[$name] : null;
    }
    /**
     * set a new param
     * @param string $_name
     * @param mixed $value
     * @return \Mvc\Helper\Request
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }
    /**
     * the action
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * set a new action name
     * @param string $action
     * @return \Mvc\Helper\Request
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }
}