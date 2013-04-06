<?php

class Lib_Definition_Config extends SimpleXMLElement
{
    public function hasDatabase()
    {
        return !empty($this->database) ? true : false;
    }
    /**
     * 
     * @return string
     */
    public function getDatabaseHost()
    {
        return (string)$this->database->host;
    }
    /**
     * 
     * @return string
     */
    public function getDatabaseUser()
    {
        return (string)$this->database->user;
    }
    /**
     * 
     * @return string
     */
    public function getDatabasePassword()
    {
        return (string)$this->database->password;
    }
    /**
     * 
     * @return string
     */
    public function getDatabaseName()
    {
        return (string)$this->database->name;
    }
    /**
     * 
     * @return boolean
     */
    public function getDatabaseStatus()
    {
        if ($this->hasDatabase() == true && $this->database->active == 'true') {
            return true;
        } else {
            return false;
        }
    }
    
    public function getDatabaseParams()
    {
        return $this->database->params;
    }
}