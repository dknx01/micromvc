<?php

class Form_TestCheck extends Form_Check_Abstract
{
    public function check()
    {
        $pattern = '/\d+/';
        if (preg_match($pattern, $this->getRequestData())) {
            return true;
        } else {
            return 'Only letters are allowed';
        }
    }
}