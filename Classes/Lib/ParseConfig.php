<?php
class Lib_ParseConfig
{
    protected $_name = 'Config/Application.xml';
    /**
     *
     * @var Lib_Definition_Config
     */
    protected $_configData = null;




    public function __construct($configFile = null)
    {
        if (!is_null($configFile)) {
            $this->_name = $configFile;
        }
        $this->_checkFile()->_parse();
    }
    
    protected function _checkFile()
    {
        if (!file_exists(realpath(__DIR__) . '/../' . $this->_name))
        {
            throw new Exception('Config file not found: ' . $this->_name);
        }
        if (substr($this->_name, -4) != '.xml') {
            throw new Exception('Config file must be xml.');
        }
        return $this;
    }
    
    protected function _parse()
    {
        $className = 'Lib_Definition_Config';
        $filename = realpath(__DIR__) . '/../' . $this->_name;
        $this->_configData = simplexml_load_file($filename, $className);
        return $this;
    }
    
    public function getConfigData()
    {
        return $this->_configData;
    }
}