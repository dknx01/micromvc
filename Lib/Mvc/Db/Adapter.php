<?php
class Db_Adapter
{
    public function __construct()
    {
        $this->_init();
    }
    
    protected function _init()
    {
        $configParser = new Config_ParseConfig();
        $dbh = null;
        /**
         * @var Config_Definition_Config
         */
        $config = $configParser->getConfigData();
        
        if ($config->getDatabaseStatus() == true) {
            $params = $config->getDatabaseParams();
            if ($config->getDatabaseType() == 'sqlite') {
                $dsn = 'sqlite:' . $config->getDatabasePath();
                try {
                    $dbh = new PDO($dsn);
                } catch (PDOException $exc) {
                    echo $exc->getMessage();
                }
            } else {
                $dsn = $config->getDatabaseType()
                     . ':host=' . $config->getDatabaseHost() . ';'
                     . 'dbname=' . $config->getDatabaseName();
                $phpversion = substr(phpversion(), 0, strpos(phpversion(), '-'));
                $phpversion = (int)str_replace('.', '', $phpversion);
                try {
                    $dbh = new PDO($dsn,
                            $config->getDatabaseUser(),
                            $config->getDatabasePassword());
                    foreach ($params as $key => $value) {
                        $stmt = 'SET ' . $dbh->quote($key) . ' ' 
                                . $dbh->quote($value);
                        $dbh->exec($stmt);
                    }
                }  
                catch(PDOException $e) {  
                    throw new Exception ($e->getMessage());
                }  
            }
        }
        return $dbh;
    }
}