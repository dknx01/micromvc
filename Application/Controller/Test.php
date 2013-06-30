<?php
/**
 * the index controller
 * @author dknx01
 * @package Application\Controller
 */
namespace Application\Controller;
use \Mvc\Controller\ControllerAbstract;
use Mvc\System;


class Test extends \Mvc\Controller\ControllerAbstract
{
    /**
     * the main action with the controller logic
     */
    public function indexAction()
    {
        $mongoDb = new \MongoClient();
//        $mongoDb->test;
//        $collection = $mongoDb->cartoons;
        $document = array( "title" => "Calvin and Hobbes", "author" => "Bill Watterson" );
        $mongoDb->selectDB('test');
        $col = $mongoDb->selectCollection('test', 'cartoons');
        $cursor = $col->find();
        foreach ($cursor as $document) {
            \Mvc\Helper\Debug::dump($document);
            //echo $document["title"] . "\n";
        }
        exit;
        $mongoDb->selectCollection('test', 'cartoons');
        $mongoDb->selectCollection('test', 'cartoons')->insert($document);
//        exit;
//        $collection->insert($document);

        // find everything in the collection
        $cursor = $mongoDb->selectCollection('test', 'cartoons')->find();
        var_dump($mongoDb->selectCollection('test', 'cartoons')->count());
// iterate through the results
        foreach ($cursor as $document) {
            \Mvc\Helper\Debug::dump($document);
            //echo $document["title"] . "\n";
        }
    }
    public function testAction()
    {
        $db = \Mvc\System::getInstance()->database();
        $cursor = $db->selectCollection('test', 'cartoons')->find();
        foreach ($cursor as $document) {

            \Mvc\Helper\Debug::dump($document);
            $model = new \Mvc\Db\MongoDb\Model();
            echo '<hr>';
            //echo $document["title"] . "\n";
        }
    }

    public function insertAction()
    {
        $model = new \Application\Db\Mongo\TestModel();
        $model->setIid(9999)->addNonMapped('foo', 123);
        \Mvc\Helper\Debug::dump($model);
        $collection = new \Application\Db\Mongo\TestCollection(System::getInstance()->serviceLocator());
        \Mvc\Helper\Debug::dump($collection);
        echo '<hr>';
        \Mvc\Helper\Debug::dump($collection->reverseMapper($model));
        \Mvc\Helper\Debug::dump($collection->insert($model));
    }
}