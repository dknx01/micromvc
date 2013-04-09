<?php
/**
 * the config parser
 * @author dknx01
 * @package Config
 */
class Config_ParseConfig
{
    /**
     *
     * @var string
     */
    protected $_name = 'Config/Application.xml';
    /**
     *
     * @var Config_Definition_Config
     */
    protected $_configData = null;

    public function __construct($configFile = null)
    {
        if (!is_null($configFile)) {
            $this->_name = $configFile;
        }
        $this->_checkFile()->_parse();
    }
    /**
     * basic checkfor the config file
     * @return \Config_ParseConfig
     * @throws Exception
     */
    protected function _checkFile()
    {
        if (!file_exists(APPDIR . '/' . $this->_name))
        {
            throw new Exception('Config file not found: ' . $this->_name);
        }
        if (substr($this->_name, -4) != '.xml') {
            throw new Exception('Config file must be xml.');
        }
        return $this;
    }
    /**
     * pares the config to our object
     * @return \Config_ParseConfig
     */
    protected function _parse()
    {
        $className = 'Config_Definition_Config';
        $filename = APPDIR . '/' . $this->_name;
        $this->_configData = simplexml_load_file($filename, $className);
        return $this;
    }
    /**
     * 
     * @return Config_Definition_Config
     */
    public function getConfigData()
    {
        return $this->_configData;
    }
}