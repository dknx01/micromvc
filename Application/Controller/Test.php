<?php
/**
 * the index controller
 * @author dknx01
 * @package Application\Controller
 */
namespace Application\Controller;
use \Mvc\Controller\ControllerAbstract;


class Test extends \Mvc\Controller\ControllerAbstract
{
    /**
     * the main action with the controller logic
     */
    public function indexAction()
    {
        \Mvc\Helper\Debug::dump($this->getRequest());exit;
    }
    public function testAction()
    {
        
    }
}