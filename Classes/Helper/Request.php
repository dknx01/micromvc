<?php
class Helper_Request
{
    protected $_baseName = 'Index';
    protected $_params = array();

    public function __construct()
    {
        if (strpos($_SERVER['QUERY_STRING'], '/') != false) {
            $this->_baseName = substr($_SERVER['QUERY_STRING'], 0, strpos($_SERVER['QUERY_STRING'], '/'));
        } elseif (!empty($_SERVER['QUERY_STRING'])) {
            $this->_baseName = $_SERVER['QUERY_STRING'];
        }
        $this->_getParams();
    }

    protected function _getParams()
    {
        $params = array();
        if (strpos($_SERVER['QUERY_STRING'], '/') != false) {
            $params = explode('?', substr($_SERVER['QUERY_STRING'], strpos($_SERVER['QUERY_STRING'], '/') + 1));
        } elseif (strpos($_SERVER['QUERY_STRING'], '?') > 1) {
            $params = explode('?', $_SERVER['QUERY_STRING']);
        }
        foreach ($params as $param) {
            $paramParts = explode('=', $param);
            $this->_params[$paramParts[0]] = $paramParts[1];
        }
        foreach ($_POST as $key => $value) {
            $this->_params[$key] = $value;
        }
    }
    /**
     * @return the $_baseName
     */
    public function getBaseName()
    {
        return $this->_baseName;
    }

    /**
     * @param string $_baseName
     * @return Helper_Request
     */
    public function setBaseName($_baseName)
    {
        $this->_baseName = $_baseName;
        return $this;
    }

    /**
     * @return the $_params
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @param string $_params
     * @return string | null
     */
    public function getParamByName($name)
    {
        return (array_key_exists($name, $this->_params) == true) ? $this->_params[$name] : null;
    }

}