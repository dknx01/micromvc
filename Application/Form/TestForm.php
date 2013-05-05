<?php

class Form_TestForm extends Form_Abstract
{
    public function form()
    {
        $this->addAttribute('onchange', 'alert()');
        $input1 = new Form_Element_Input();
        $this->addElement($input1);
        $input2 = new Form_Element_Input();
        $input2->setName('name')->addAttribute('size', 50);
        $this->addElement($input2);
        $textarea = new Form_Element_Textarea();
        $this->addElement($textarea);
        $selectList = new Form_Element_SelectList();
        $selectList->addOption('Select1')
                   ->addOption('Select2');
        $selectList->addOption('SubSelect1', null, 'Gruppe1');
        $selectList->addOption('SubSelect2', null, 'Gruppe1');
        $selectList->addOption('SubSelect1', null, 'Gruppe2');
        $this->addElement($selectList);
        $input4 = new Form_Element_Input();
        $check = new Form_TestCheck();
        $request = Registry::getInstance()->get('request');
        $check->setRequestData($request->getParamByName('testname'));
        $input4->setName('testname')->setCheck($check);
        $this->addElement($input4, 'test1');
        $input3 = new Form_Element_Input();
        $input3->setType('submit')->setValue('WEG')->setName('weg');
        $this->addElement($input3);
    }
}