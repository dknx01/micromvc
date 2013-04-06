<?php
class Db_SystemDml
{
    protected $_name = 'system';
    protected $_connection = null;

    public function __construct()
    {
        Registry::getInstance()->set('proccededConnection', array());
    }
    public function insert(Db_SystemModell $modell)
    {

        $sql = 'INSERT IGNORE INTO `' . $this->_name
            . '` (`name`, `contact`, `place`, `infoLink`, `classification`, `isForeign`) VALUES(';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getName())) . '\', ';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getContact())) . '\', ';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getPlace())) . '\', ';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getInfoLink())) . '\', ';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getClassification())) . '\',';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getIsForeign())) . '\'';
        $sql .= ')';
        mysql_query($sql, Registry::getInstance()->get('db')) || die(mysql_error(Registry::getInstance()->get('db')));
        $id = mysql_insert_id(Registry::getInstance()->get('db'));
        return $id;
    }

    public function fetchAll()
    {
        $sql = 'SELECT * FROM `' . $this->_name . '`';
        $result = mysql_query($sql, Registry::getInstance()->get('db'));
        $results = array();
        while ($model = mysql_fetch_object($result, 'Db_SystemModell')) {
            $results[] = $model;
        }

        return $this->getChildren($results);
    }
    /**
     *
     * @param array $parentList
     */
    protected function getChildren($parentList)
    {
        $systemConnection = new Db_SystemConnectionDml('localhost', 'visi', 'visi', 'visi');
        foreach ($parentList as $key => $item) {
            /**
             * @var $item Db_SystemModell
             */
            $item->childrenIds = $systemConnection->getAllByParentId($item->id);
            $parentList[$key] = $item;
        }

        return $parentList;
    }

    public function getAllById($id)
    {
        $id = (int)$id;
        $sql = 'SELECT * FROM `' . $this->_name . '` WHERE `id` = ' . mysql_real_escape_string($id);
        $result = mysql_query($sql, Registry::getInstance()->get('db'));
        $results = array();
        while ($model = mysql_fetch_object($result, 'Db_SystemModell')) {
            $results[] = $model;
        }
        $results = $this->getChildren($results);
        return $results;
    }
    /**
     *
     * @param int $id
     */
    public function deleteById($id)
    {
        $sql = 'DELETE FROM `' . $this->_name . '` WHERE id = ' . (int)$id;
        mysql_query($sql, Registry::getInstance()->get('db'));
    }

}