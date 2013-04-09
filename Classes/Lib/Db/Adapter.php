<?php
class Lib_Db_Adapter
{
    public function __construct()
    {
        $this->_init();
    }
    
    protected function _init()
    {
        $config = new Lib_ParseConfig();
        $dbh = null;
        $config = $config->getConfigData();
        
        if ($config->getDatabaseStatus() == true) {
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
                try {
                    $dbh = new PDO($dsn,
                            $config->getDatabaseUser(),
                            $config->getDatabasePassword());
                }  
                catch(PDOException $e) {  
                    echo $e->getMessage();
                }  
            }
        }
        return $dbh;
    }
}