<?php
/**
 * the index controller
 * @author dknx01
 * @package Controller
 */
class Controller_Index extends Controller_Abstract
{
    /**
     * the main action with the controller logic
     */
    public function index()
    {
        $testDml = new Db_TestTable();
        $this->addToView('testData',$testDml->fetchAll());
        $form = new Form_TestForm();
//        $form->setAction('test');
        $this->addToView('testform', $form->render());
        if ($this->getRequest()->getParamByName('weg')) {
            if ($form->check()->errorNumbers() > 0) {
                $this->addToView('formErrors', $form->check()->getAllErrors());
            }
        }
    }
}