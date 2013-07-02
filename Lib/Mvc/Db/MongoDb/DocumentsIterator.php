<?php
/**
 * 
 * @author 
 * Created by JetBrains PhpStorm.
 * User: erik
 * Date: 02.07.13
 * Time: 19:27
 * To change this template use File | Settings | File Templates.
 */

namespace Mvc\Db\MongoDb;


class DocumentsIterator implements \Iterator
{
    /**
     * @var array
     */
    private $data = array();
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @return \Mvc\Db\MongoDb\DocumentsIterator
     */
    public function rewind()
    {
        $this->position = 0;
        return $this;
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        return $this->position <= count($this->data);
    }

    /**
     * @return \Mvc\Db\MongoDb\Document
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * @return \Mvc\Db\MongoDb\DocumentsIterator
     */
    public function next()
    {
        $this->position++;
        return $this;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @param Document $data
     * @return \Mvc\Db\MongoDb\DocumentsIterator
     */
    public function add(\Mvc\Db\MongoDb\Document $data)
    {
        $this->data[] = $data;
        return $this;
    }
}