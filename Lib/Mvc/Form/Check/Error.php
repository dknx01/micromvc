<?php

class Form_Check_Error
{
    protected $errors = array();
    public function addError($element, $message)
    {
        $this->errors[$element] = $message;
        return $this;
    }
    public function getError($element)
    {
        return $this->errors[$element];
    }
    public function getAllErrors()
    {
        return $this->errors;
    }
    public function errorNumbers()
    {
        return count($this->errors);
    }
}