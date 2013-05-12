<?php
/**
 * the adapter for our database connection
 * @author dknx01
 * @package Mvc\Db
 */

namespace Mvc\Db;
use \PDO as PDO;
use \Mvc\Config as Config;
class Adapter extends PDO
{
    /**
     * the generated dsn
     * @var string
     */
    protected $dsn = '';
    /**
     * the database user
     * @var string
     */
    protected $user = '';
    /**
     * the database password
     * @var string
     */
    protected $password = '';
    /**
     * the database connection parameters
     * @var array
     */
    protected $params = array();
    /**
     * the constructor
     */
    public function __construct()
    {
        $this->init();
        parent::__construct($this->dsn, $this->user, $this->password);
        $this->proccedParams();
    }
    /**
     * procces all parameters
     */
    protected function proccedParams()
    {
        foreach ($this->params as $key => $value) {
            $stmt =  $stmt = 'SET ' . $this->quote($key) . ' '
                                . $this->quote($value);
            $this->exec($stmt);
        }
    }
    /**
     * prepare a new connection based on the configuration file
     */
    protected function init()
    {
        $configParser = new Config\ParseConfig();
        /**
         * @var \Mvc\Config\Definition\Config
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