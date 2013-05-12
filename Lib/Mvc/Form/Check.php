<?php
/**
 * the default form check definition
 * @author dknx01
 * @package Mvc\Form
 */

namespace Mvc\Form;
use \Mvc\Form\Check\CheckAbstract as CheckAbstract;

class Check extends CheckAbstract
{
    /**
     * @see \Mvc\Form\Check\CheckAbstract
     * @return boolean
     */
    public function check()
    {
        return true;
    }
}