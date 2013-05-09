<?php
/**
 * class for the check errors
 * @author dknx01
 * @package Form\Check
 */
class Form_Check_Error
{
    /**
     * contains all errors
     * @var array
     */
    protected $errors = array();
    /**
     * add a new error to the collection
     * @param string $element
     * @param string $message
     * @return \Form_Check_Error
     */
    public function addError($element, $message)
    {
        $this->errors[$element] = $message;
        return $this;
    }
    /**
     * returns the error message for an element
     * @param string $element
     * @return type
     */
    public function getError($element)
    {
        return $this->errors[$element];
    }
    /**
     * returns all errors
     * @return array
     */
    public function getAllErrors()
    {
        return $this->errors;
    }
    /**
     * the numbers of errors in this collection
     * @return int
     */
    public function errorNumbers()
    {
        return (int)count($this->errors);
    }
}