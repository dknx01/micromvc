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
        $this->queryString = substr($_SERVER['REQUEST_URI'], 1);
        $firstSlash = strpos($_SERVER['QUERY_STRING'], '/');
        $secondSlash = $firstSlash == false
                       ? false
                       : strpos($_SERVER['QUERY_STRING'], '/', $firstSlash);
        if ($firstSlash != false) {
            $this->extractParams();
            $this->controllerName = ucfirst(substr($_SERVER['QUERY_STRING'], 0, $firstSlash));
            if ($secondSlash != false) {
                $this->action = lcfirst(
                                    substr(
                                            $_SERVER['QUERY_STRING'],
                                            $firstSlash + 1, 
                                            $secondSlash - 1
                                        )
                                );
                $this->extractParams();
            }
            if (empty($this->action)) {
                $this->action = 'index';
            }
        }
        $this->removeQuestionmark();
        $this->getAllParams();
    }
    private function removeQuestionmark()
    {
        preg_match('/\??(.*)/', $this->queryString, $matches);
        $this->queryString = $matches[1];
    }
    private function extractParams()
    {
        $posSlash = strpos($this->queryString, '/');
        if ($posSlash != false) {
            $this->queryString = substr($this->queryString, $posSlash + 1);
        } else {
            $this->queryString = '';
        }
    }

    /**
     * retrive all params get by GET or POST method
     */
    protected function getAllParams()
    {
        $params = array();
        if (strpos($this->queryString, '/') != false) {
            $params = explode('/', $this->queryString);
        } else {
            if (!empty($this->queryString)) {
                $params = explode('&', $this->queryString);
            }
        }
        if (count($params) > 0) {
            foreach ($params as $param) {
                $split = strpos($param, '=');
                if ($split != false) {
                    $this->params[substr($param, 0, $split)] = substr($param, $split + 1);
                } else {
                    $this->params[$param] = '';
                }
            }
        }
        foreach ($_POST as $key => $value) {
            $this->params[$key] = $value;
        }
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