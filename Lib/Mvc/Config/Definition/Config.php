<?php

class Config_Definition_Config extends SimpleXMLElement
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
    /**
     * 
     * @return string
     */
    public function getDatabaseType()
    {
        $attributes = $this->database->attributes();
        $attributes = (array)$attributes;
        $attributes = $attributes['@attributes'];
        return $attributes['type'];
    }
    
    /**
     * 
     * @return string
     */
    public function getDatabasePath()
    {
        return (string)$this->database->path;
    }
    /**
     * 
     * @param string $name
     * @return mixed the value
     */
    public function getParam($name)
    {
        $node = empty($this->$name) ? null : $this->$name;
        if (!is_null($node)) {
            $value = $this->checkChildren($node);
        } else {
            $value = $node;
        }
        return $value;
    }
    /**
     * 
     * @param SimpleXMLElement $node
     * @return array|string
     */
    protected function checkChildren($node)
    {
        if (count($node->children()) > 0) {
            $value = array();
            if (count($node->attributes()) > 0) {
                $attributes = (array) $node->attributes();
                $attributes = $attributes['@attributes'];
                foreach ($attributes as $k => $v) {
                    $value['@attributes'][$k] = (string)$v;
                }
            }
            foreach ($node->children() as $k => $v) {
                if (count($v->children()) > 0) {
                    $value[$k] = $this->checkChildren($v);
                } else {
                    $value[$k] = (string)$v;
                }
            }
        } else {
            $value = (string)$node;
        }
        return $value;
    }
}