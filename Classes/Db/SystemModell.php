<?php
class Db_SystemModell
{
    /**
     *
     * @var string
     */
    protected $_name = '';
    /**
     *
     * @var string
     */
    protected $_contact = '';
    /**
     *
     * @var string
     */
    protected $_place = '';

    /**
     *
     * @var string
     */
    protected $_infoLink = '';
    /**
     *
     * @var string
     */
    protected $_classification = '';
    /**
     *
     * @var array
     */
    protected $_childrenIds = array();
    /**
     *
     * @var int
     */
    protected $_isForeign = 0;
    /**
     * @return the $_name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $_name
     * @return Db_SystemModell
     */
    public function setName($_name)
    {
        $this->_name = $_name;
        return $this;
    }

    /**
     * @return the $_contact
     */
    public function getContact()
    {
        return $this->_contact;
    }

    /**
     * @param string $_contact
     * @return Db_SystemModell
     */
    public function setContact($_contact)
    {
        $this->_contact = $_contact;
        return $this;
    }

    /**
     * @return the $_place
     */
    public function getPlace()
    {
        return $this->_place;
    }

    /**
     * @param string $_place
     * @return Db_SystemModell
     */
    public function setPlace($_place)
    {
        $this->_place = $_place;
        return $this;
    }

    /**
     * @return the $_infoLink
     */
    public function getInfoLink()
    {
        return $this->_infoLink;
    }

    /**
     * @param string $_infoLink
     * @return Db_SystemModell
     */
    public function setInfoLink($_infoLink)
    {
        $this->_infoLink = $_infoLink;
        return $this;
    }

    /**
     * @return the $_classification
     */
    public function getClassification()
    {
        return $this->_classification;
    }

    /**
     * @param string $_classification
     * @return Db_SystemModell
     */
    public function setClassification($_classification)
    {
        $this->_classification = $_classification;
        return $this;
    }
    /**
     * @return the $_childrenIds
     */
    public function getChildrenIds()
    {
        return $this->_childrenIds;
    }

    /**
     * @param array $_childrenIds
     * @return Db_SystemModell
     */
    public function setChildrenIds($_childrenIds)
    {
        $this->_childrenIds = $_childrenIds;
        return $this;
    }
    /**
     * @return the $_isForeign
     */
    public function getIsForeign()
    {
        return $this->_isForeign;
    }

    /**
     * @param number $_isForeign
     * @return Db_SystemModell
     */
    public function setIsForeign($_isForeign)
    {
        $this->_isForeign = $_isForeign;
        return $this;
    }

}