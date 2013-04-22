<?php
class Db_Adapter extends PDO
{
    protected $dsn = '';
    protected $user = '';
    protected $password = '';
    protected $params = array();
    public function __construct()
    {
        $this->init();
        parent::__construct($this->dsn, $this->user, $this->password);
        $this->proccedParams();
    }

    protected function proccedParams()
    {
        foreach ($this->params as $key => $value) {
            $stmt =  $stmt = 'SET ' . $this->quote($key) . ' '
                                . $this->quote($value);
            $this->exec($stmt);
        }
    }

    protected function init()
    {
        $configParser = new Config_ParseConfig();
        /**
         * @var Config_Definition_Config
         */
        $config = $configParser->getConfigData();

        if ($config->getDatabaseStatus() == true) {
            $this->params = $config->getDatabaseParams();
            if ($config->getDatabaseType() == 'sqlite') {
                $this->dsn = 'sqlite:' . $config->getDatabasePath();
            } else {
                $this->dsn = $config->getDatabaseType()
                    . ':host=' . $config->getDatabaseHost() . ';'
                    . 'dbname=' . $config->getDatabaseName();
                $this->user = $config->getDatabaseUser();
                $this->password = $config->getDatabasePassword();
                $this->params = $config->getDatabaseParams();
            }
        }
    }
}