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
    public function indexAction()
    {
        $session = new Session_Session();
        $session->hallo = 'Da sollte was stehen';
        $session2 = new Session_Session('TEST');
        $session2->hallo = 'hier ist etwas';
        Helper_Debug::dump($session->hallo);
        Helper_Debug::dump($session2->hallo);
        Helper_Debug::dump($_SESSION);
        exit;
        $testDml = new Db_TestTable();
        $this->addToView('testData',$testDml->fetchAll());
        $form = new Form_TestForm();
        $this->addToView('testform', $form->render());
        if ($this->getRequest()->getParamByName('weg')) {
            if ($form->check()->errorNumbers() > 0) {
                $this->addToView('formErrors', $form->check()->getAllErrors());
            }
        }
    }
    public function testAction()
    {
        
    }
}