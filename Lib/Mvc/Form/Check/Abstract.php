<?php
abstract class Form_Check_Abstract
{
    protected $requestData = '';
    protected $required = false;
    
//    abstract function definition();

    abstract function check();
    public function getRequestData()
    {
        return $this->requestData;
    }

    public function setRequestData($requestData)
    {
        $this->requestData = $requestData;
        return $this;
    }
    public function isRequired($required = null)
    {
        if (is_null($required)) {
            return $this->required;
        } else {
            $this->required = (boolean)$required;
            return $this;
        }
    }
    
    public function checkRequired($name)
    {
        $data = $this->getRequestData();
        if ($this->isRequired() == true && !empty($data[$name])){
            return true;
        }
        if ($this->isRequired() == false) {
            return true;
        } else {
            return false;
        }
    }
}