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
    protected $name = 'Config/Application.xml';
    /**
     *
     * @var Config_Definition_Config
     */
    protected $configData = null;

    public function __construct($configFile = null)
    {
        if (!is_null($configFile)) {
            $this->name = $configFile;
        }
        $this->checkFile()->parse();
    }
    /**
     * basic checkfor the config file
     * @return \Config_ParseConfig
     * @throws Exception
     */
    protected function checkFile()
    {
        if (!file_exists(APPDIR . '/' . $this->name))
        {
            throw new Exception('Config file not found: ' . $this->name);
        }
        if (substr($this->name, -4) != '.xml') {
            throw new Exception('Config file must be xml.');
        }
        return $this;
    }
    /**
     * pares the config to our object
     * @return \Config_ParseConfig
     */
    protected function parse()
    {
        $className = 'Config_Definition_Config';
        $filename = APPDIR . '/' . $this->name;
        $this->configData = simplexml_load_file($filename, $className);
        return $this;
    }
    /**
     * 
     * @return Config_Definition_Config
     */
    public function getConfigData()
    {
        return $this->configData;
    }
}