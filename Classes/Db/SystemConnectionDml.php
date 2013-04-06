<?php
class Db_SystemConnectionDml
{
    protected $_name = 'systemConnection';
    protected $_connection = null;

    public function insert(Db_SystemConnectionModell $modell)
    {

        $sql = 'INSERT INTO `' . $this->_name . '` '
            . '( `systemParent`, `systemChild`, `severity`, `malfunctionImpact`, `failureProbability`, `description`) '
            . 'VALUES (';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getSystemParent())) . '\', ';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getSystemChild())) . '\', ';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getSeverity())) . '\', ';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getMalfunctionImpact())) . '\', ';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getFailureProbability())) . '\', ';
        $sql .= '\'' . mysql_real_escape_string(utf8_decode($modell->getDescription())) . '\' ';
        $sql .= ')';
        $sql .= ' ON DUPLICATE KEY UPDATE';
        $sql .= ' `severity` = VALUES(severity),';
        $sql .= ' `malfunctionImpact` = VALUES(malfunctionImpact),';
        $sql .= ' `failureProbability` = VALUES(failureProbability),';
        $sql .= ' `description` = VALUES(description)';
        mysql_query($sql, Registry::getInstance()->get('db')) || die(mysql_error(Registry::getInstance()->get('db')) .  __FILE__ . ':' . __LINE__);
    }

    public function deleteByParentChild(Db_SystemConnectionModell $modell)
    {
        $sql = 'DELETE FROM `' . $this->_name . '` ';
        $sql .= ' WHERE `systemParent` = ' . (int)$modell->getSystemParent();
        $sql .= ' AND `systemChild` = ' . (int)$modell->getSystemChild();
        $sql .= ' LIMIT 1';
        mysql_query($sql, Registry::getInstance()->get('db')) || die(mysql_error(Registry::getInstance()->get('db')) .  __FILE__ . ':' . __LINE__);
    }

    public function getAllByParentId($id)
    {
        $sql = 'SELECT systemChild FROM `' . $this->_name . '` WHERE `systemParent` = ' . mysql_real_escape_string((int)$id);
        $result = mysql_query($sql, Registry::getInstance()->get('db'));
        $results = array();
        while ($row = mysql_fetch_assoc($result)) {
            $results[] = $row['systemChild'];
        }

        return $results;
    }
    public function getAllByIds($parentId, $childId)
    {
        $sql = 'SELECT * FROM `' . $this->_name . '` WHERE '
            . '`systemParent` = ' . mysql_real_escape_string((int)$parentId)
            . ' AND `systemChild` = ' . mysql_real_escape_string($childId);
        $result = mysql_query($sql, Registry::getInstance()->get('db'));
        $results = array();
        while ($model = mysql_fetch_object($result, 'Db_SystemConnectionModell')) {
            $results[] = $model;
        }

        return $results[0];
    }

    /**
     *
     * @param int $id
     */
    public function deleteById($id)
    {
        $sql = 'DELETE FROM `' . $this->_name . '` WHERE systemParent = ' . (int)$id . ' OR systemChild = ' . (int)$id;
        mysql_query($sql, Registry::getInstance()->get('db'));
    }
}