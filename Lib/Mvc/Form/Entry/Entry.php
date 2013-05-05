<?php

class Form_Entry_Entry extends Form_Entry_Abstract
{
    protected $element = null;
    protected $check = null;
    public function __construct(Form_Element_Abstract $element, Form_Check $check)
    {
        $this->element = $element;
        $this->check = $check;
    }

    public function render()
    {
        $entry = '';
        if ($this->element instanceof Form_Element_Abstract 
            && method_exists($this->element, 'render')
        ){
            $entry .= $entry->render() . PHP_EOL;
        }
        return $entry;
    }
}