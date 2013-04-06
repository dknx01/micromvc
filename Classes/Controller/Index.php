<?php
class Controller_Index extends Controller_Abstract
{
    /**
     *
     * @var Db_SystemDml
     */
    protected $_dmlSystem = null;
    public function run()
    {
        $this->_dmlSystem = new Db_SystemDml();
        if (Registry::getInstance()->get('asTree') == true) {
            Registry::getInstance()->set('treeVis', $this->fromDbAsTree()->asJson());
        } else {
            Registry::getInstance()->set('netVis', $this->fromDbAsNet()->asJson());
        }
    }

/**
     * @return DataObjects_ItemRoot
     */
    public function fromDbAsTree()
    {
        $data = $this->_dmlSystem->fetchAll();
        $rootObject = new DataObjects_ItemRoot();
        $root = new DataObjects_Item();
        $dataRoot = $data[0];

        $data = array_slice($data, 1);

        $rootDataElement = new stdClass();
        $rootDataElement->contact = $dataRoot->contact;
        $rootDataElement->classification = $dataRoot->classification;
        $rootDataElement->place = $dataRoot->place;
        $rootDataElement->infoLink = $dataRoot->infoLink;

        $root->setName($dataRoot->name)
             ->setData($rootDataElement)
             ->setChildren($this->_proccedChildren($dataRoot->id, $dataRoot->childrenIds));
        foreach ($data as $key => $entry) {
            $item = new DataObjects_Item();
            $entryData = new stdClass();
            $entryData->contact = $entry->contact;
            $entryData->place = $entry->place;
            $entryData->infoLink = $entry->infoLink;
            $entryData->classification = $entry->classification;
            $item->setName($entry->name)
                 ->setData($entryData)
                 ->setChildren($this->_proccedChildren($entry->id, $entry->childrenIds));
            $root->addChild($item);
        }
        return $rootObject->setRoot($root);
    }

    public function fromDbAsNet()
    {
        $dbData = $this->_dmlSystem->fetchAll();
        $nodeCollection = new DataObjects_Net_NodeCollection();
        $dataNode = new stdClass();
        $name = '$color';
        $dataNode->$name = '#FF8000';
        $name = '$type';
        $dataNode->$name = 'circle';
        $name = '$dim';
        $dataNode->$name =10;

        foreach ($dbData as $key => $value) {
            $node = new DataObjects_Net_Node();
            $node->setData($dataNode);
            $node->setName($value->name);
            $node = $this->_proccedAdjacencies($value, $node);

            $nodeCollection->addEntry($node);
        }
        return $nodeCollection;
    }

    /**
     *
     * @param array $dbObject
     * @return unknown
     */
    protected function _proccedChildren($parentId, $childrenIds)
    {
        $children = array();
        foreach ($childrenIds as $key => $childId) {
            if ($this->_checkIfAlreadyProcceded($parentId, $childId) == false) {
                $children[] = $this->_getChildData($childId);
            }

        }
        return $children;
    }

    protected function _checkIfAlreadyProcceded($parentId, $childId)
    {
        $return = false;
        $alreadyProcced = Registry::getInstance()->get('proccededConnection');
        if (is_null($alreadyProcced)) {
            $alreadyProcced = array();
        }
        if (in_array($parentId . '#' . $childId, $alreadyProcced)) {
            $return = true;
        } else {
            $alreadyProcced[] = $parentId . '#' . $childId;
        }
        Registry::getInstance()->set('proccededConnection', $alreadyProcced);

        return $return;
    }

    protected function _getChildData($id)
    {
        $child = new DataObjects_Item();
        $dbDataDb = $this->_dmlSystem->getAllById((int)$id);
        foreach ($dbDataDb as $key => $value) {
            $dbData = $value;
        }
        if (isset($dbData)) {
            $childData = new stdClass();
            $childData->contact = $dbData->contact;
            $childData->classification = $dbData->classification;
            $childData->place = $dbData->place;
            $childData->infoLink = $dbData->infoLink;
            $child->setName($dbData->name)
                  ->setData($childData)
                  ->setChildren($this->_proccedChildren($dbData->id, $dbData->childrenIds));
        }
        return $child;
    }

    protected function _proccedAdjacencies(Db_SystemModell $data, DataObjects_Net_Node $node)
    {

        foreach ($data->childrenIds as $id) {
            $adjDataDb = $this->_dmlSystem->getAllById($id);
            foreach ($adjDataDb as $key => $value) {
                $adjData = $value;
            }
            $adjacency = new DataObjects_Net_NodeAdjacencies();
            $adjacency->setName($adjData->name);
            $node->addAdjacency($adjacency);
        }
        return $node;
    }
}