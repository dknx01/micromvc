<?php
/**
 * class to set a form check
 * @author dknx01
 * @package Form\Check
 */
abstract class Form_Check_Abstract
{
    /**
     * data from the request
     * @var string
     */
    protected $requestData = '';
    /**
     * is this element required and cannot be empty
     * @var boolean
     */
    protected $required = false;
    /**
     * the check definition
     */
    abstract function check();
    /**
     * the request data
     * @return string
     */
    public function getRequestData()
    {
        return $this->requestData;
    }
    /**
     * set the request data
     * @param mixed $requestData
     * @return \Form_Check_Abstract
     */
    public function setRequestData($requestData)
    {
        $this->requestData = $requestData;
        return $this;
    }
    /**
     * set or returns if thsi element is required an cannot be empty
     * @param boolean $required
     * @return \Form_Check_Abstract
     */
    public function isRequired($required = null)
    {
        if (is_null($required)) {
            return $this->required;
        } else {
            $this->required = (boolean)$required;
            return $this;
        }
    }
    /**
     * checks if this element is required an not empty 
     * @return boolean
     */
    public function checkRequired()
    {
        $data = $this->getRequestData();
        if ($this->isRequired() == true && !empty($data)){
            return true;
        }
        if ($this->isRequired() == false) {
            return true;
        } else {
            return false;
        }
    }
}