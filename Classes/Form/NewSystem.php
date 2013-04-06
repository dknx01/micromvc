<?php
class Form_NewSystem extends Form_Abstract
{
    public function main()
    {
        $this->addFormDefinition('systemName')
             ->addFormDefinition('systemClassification')
             ->addFormDefinition('severity')
             ->addFormDefinition('description')
             ->addFormDefinition('malfunctionImpact');
    }
}