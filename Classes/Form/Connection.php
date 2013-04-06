<?php
class Form_Connection extends Form_Abstract
{
    public function main()
    {
        $this->addFormDefinition('severity')
             ->addFormDefinition('description')
             ->addFormDefinition('malfunctionImpact')
    }
}