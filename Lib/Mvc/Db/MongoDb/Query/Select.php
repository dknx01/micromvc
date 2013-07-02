<?php
/**
 * 
 * @author 
 * Created by JetBrains PhpStorm.
 * User: erik
 * Date: 30.06.13
 * Time: 18:10
 * To change this template use File | Settings | File Templates.
 */

namespace Mvc\Db\MongoDb\Query;

use \Mvc\Db\MongoDb\Query\QueryAbstract as Query;

class Select extends Query
{
    const NOT_EQUALS = '$ne:';
    const OR_CONDITION = '$or:';
    const GREATER_THAN = '$gt:';
    const LOWER_THAN = '$lt:';
    const LOWER_THAN_EQUALS = '$lte:';
    const ORDER_ASC = 1;
    const ORDER_DESC = -1;

    protected $limit = null;
    protected $fields = array();
    protected $where = array();
    protected $order = array();
    protected $skip = 0;

    /**
     * @return \MongoCursor
     */
    public function findAll()
    {
        return $this->find();
    }

    /**
     * @param $id
     * @return array|null
     */
    public function findByObjectId($id)
    {
        $mid = new \MongoId($id);
        $query = array('_id' => $mid);
        return $this->findOne($query);
    }

    /**
     * @param int $limit
     * @param int $skip
     * @return \Mvc\Db\MongoDb\Query\Select
     */
    public function limit($limit, $skip = 0)
    {
        $this->limit = $limit;
        $this->skip = $skip;
        return $this;
    }

    /**
     * @param string|array $field
     * @return \Mvc\Db\MongoDb\Query\Select
     */
    public function field($field)
    {
        if (is_array($field)) {
            $this->fields = $field;
        } else {
            $this->fields[$field] = 1;
        }

        return $this;
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return \Mvc\Db\MongoDb\Query\Select
     */
    public function where($field, $value = 1)
    {
        $this->where[$field] = $value;
        return $this;
    }

    /**
     * @param string $field
     * @param int $direction
     * @return \Mvc\Db\MongoDb\Query\Select
     */
    public function sort($field, $direction = self::ORDER_ASC)
    {
        $this->order[$field] = $direction;
        return $this;
    }

    /**
     * @param string $field
     * @param string $condition
     * @return \Mvc\Db\MongoDb\Query\Select
     */
    public function like($field, $condition)
    {
        $this->where[$field] = new \MongoRegex($condition);
        return $this;
    }

    /**
     * @return \Mvc\Db\MongoDb\DocumentsIterator
     */
    public function execute()
    {
        $result = new \Mvc\Db\MongoDb\DocumentsIterator();

        $query = $this->find($this->where, $this->fields);
        if (count($this->order) > 0) {
            $query->sort($this->order);
        }
        if (!is_null($this->limit)) {
            $query->limit($this->limit)->skip($this->skip);
        }

        foreach ($query as $document) {
            $documentMd = new \Mvc\Db\MongoDb\Document();
            $documentMd->setCollectionName($this->getName());
            if (count($document) > 1) {
                foreach ($document as $field => $value) {
                    if ($field == '_id') {
                        $documentMd->setObjectId($value);
                    } else {
                        $documentMd->addNonMapped($field, $value);
                    }
                }
            }
            $result->add($documentMd);
        }
        return $result;
    }
}