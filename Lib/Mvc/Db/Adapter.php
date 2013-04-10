<?php
class Db_Adapter extends PDO
{
    protected $_dsn = '';
    protected $_user = '';
    protected $_password = '';
    protected $_params = array();
    public function __construct()
    {
        $this->_init();
        parent::__construct($this->_dsn, $this->_user, $this->_password);
        $this->_proccedParams();
    }

    protected function _proccedParams()
    {
        foreach ($this->_params as $key => $value) {
            $stmt =  $stmt = 'SET ' . $this->quote($key) . ' '
                                . $this->quote($value);
            $this->exec($stmt);
        }
    }

    protected function _init()
    {
        $configParser = new Config_ParseConfig();
        /**
         * @var Config_Definition_Config
         */
        $config = $configParser->getConfigData();

        if ($config->getDatabaseStatus() == true) {
            $this->_params = $config->getDatabaseParams();
            if ($config->getDatabaseType() == 'sqlite') {
                $this->_dsn = 'sqlite:' . $config->getDatabasePath();
            } else {
                $this->_dsn = $config->getDatabaseType()
                    . ':host=' . $config->getDatabaseHost() . ';'
                    . 'dbname=' . $config->getDatabaseName();
                $this->_user = $config->getDatabaseUser();
                $this->_password = $config->getDatabasePassword();
                $this->_params = $config->getDatabaseParams();
            }
        }
    }
}