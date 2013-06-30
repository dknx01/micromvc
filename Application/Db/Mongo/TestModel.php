<?php
namespace Application\Db\Mongo;
use \Mvc\Db\MongoDb\Model as Model;

class TestModel extends Model
{
    protected $iid;

    /**
     * @param $iid
     *
     * @return \Application\Db\Mongo\TestModel
     */
    public function setIid($iid)
    {
        $this->iid = $iid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIid()
    {
        return $this->iid;
    }

}