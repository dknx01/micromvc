<?php
/**
 * the index controller
 * @author dknx01
 * @package Application\Controller
 */
namespace Application\Controller;
use \Mvc\Controller\ControllerAbstract;
use \Mvc\Session\Session as Session;
use \Application\Db\TestTable as TestTable;
use \Application\Form\TestForm as TestForm;

class Index extends \Mvc\Controller\ControllerAbstract
{
    /**
     * the main action with the controller logic
     */
    public function indexAction()
    {
        \Mvc\Helper\Debug::dump($this->getRequest());exit;
//        $session = new Session();
//        $session->hallo = 'Da sollte was stehen';
//        $session2 = new Session('TEST');
//        $session2->hallo = 'hier ist etwas';
//        $testDml = new TestTable();
//        $this->addToView('testData',$testDml->fetchAll());
//        $form = new TestForm();
////        \Mvc\Helper\Debug::dump($form);
//        $this->addToView('testform', $form->render());
//        if ($this->getRequest()->getParamByName('weg')) {
//            if ($form->check()->errorNumbers() > 0) {
//                $this->addToView('formErrors', $form->check()->getAllErrors());
//            }
//        }
    }
    public function testAction()
    {

    }
}