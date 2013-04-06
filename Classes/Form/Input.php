<?php
class Form_Input extends Form_Abstract
{
    public function main()
    {
        $this->addFormDefinition('systemName', array('optional' => false))
             ->addFormDefinition('systemClassification', array('optional' => false));
    }
}