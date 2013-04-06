<?php
class DataObjects_Net_NodeCollection
{
    protected $_entries = array();
    /**
     * @return the $_entries
     */
    public function getEntries()
    {
        return $this->_entries;
    }

    /**
     * @param array $_entries
     * @return DataObjects_Net_NodeCollection
     */
    public function setEntries($_entries)
    {
        $this->_entries = $_entries;
        return $this;
    }
    public function addEntry(DataObjects_Net_Node $node)
    {
        $this->_entries[] = $node;
        return $this;
    }

    public function asJson()
    {
        $data = array();
        foreach ($this->getEntries() as $entry) {
            $data[] = $entry->asStdClass();
        }

        return json_encode($data);
    }

}