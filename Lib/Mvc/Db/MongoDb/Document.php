<?php
/**
 * 
 * @author 
 * Created by JetBrains PhpStorm.
 * User: erik
 * Date: 01.07.13
 * Time: 22:14
 * To change this template use File | Settings | File Templates.
 */

namespace Mvc\Db\MongoDb;

use \Mvc\Db\MongoDb\Model as Model;

class Document extends Model
{
    protected $collectionName = 'test';

    /**
     * @param string $collectionName
     *
     * @return \Mvc\Db\MongoDb\Document
     */
    public function setCollectionName($collectionName)
    {
        $this->collectionName = $collectionName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCollectionName()
    {
        return $this->collectionName;
    }
}