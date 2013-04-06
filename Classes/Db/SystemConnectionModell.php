<?php
class Db_SystemConnectionModell
{
    /**
     *
     * @var int
     */
    protected $_systemParent = 0;
    /**
     *
     * @var int
     */
    protected $_systemChild = 0;
    /**
     *
     * @var string
     */
    protected $_severity = '';
    /**
     *
     * @var string
     */
    protected $_malfunctionImpact = '';
    /**
     *
     * @var string
     */
    protected $_failureProbability = '';
    /**
     *
     * @var string
     */
    protected $_description = '';
    /**
     * @return the $_systemParent
     */
    public function getSystemParent()
    {
        return $this->_systemParent;
    }

    /**
     * @param number $_systemParent
     * @return Db_SystemConnectionModell
     */
    public function setSystemParent($_systemParent)
    {
        $this->_systemParent = (int)$_systemParent;
        return $this;
    }

    /**
     * @return the $_systemChild
     */
    public function getSystemChild()
    {
        return $this->_systemChild;
    }

    /**
     * @param number $_systemChild
     * @return Db_SystemConnectionModell
     */
    public function setSystemChild($_systemChild)
    {
        $this->_systemChild = (int)$_systemChild;
        return $this;
    }

    /**
     * @return the $_severity
     */
    public function getSeverity()
    {
        return $this->_severity;
    }

    /**
     * @param string $_severity
     * @return Db_SystemConnectionModell
     */
    public function setSeverity($_severity)
    {
        $this->_severity = $_severity;
        return $this;
    }
    /**
     * @return the $_malfunctionImpact
     */
    public function getMalfunctionImpact()
    {
        return $this->_malfunctionImpact;
    }

    /**
     * @param string $_malfunctionImpact
     * @return Db_SystemConnectionModell
     */
    public function setMalfunctionImpact($_malfunctionImpact)
    {
        $this->_malfunctionImpact = $_malfunctionImpact;
        return $this;
    }
    /**
     * @return the $_failureProbability
     */
    public function getFailureProbability()
    {
        return $this->_failureProbability;
    }

    /**
     * @param string $_failureProbability
     * @return Db_SystemConnectionModell
     */
    public function setFailureProbability($_failureProbability)
    {
        $this->_failureProbability = $_failureProbability;
        return $this;
    }
    /**
     * @return the $_description
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @param string $_description
     * @return Db_SystemConnectionModell
     */
    public function setDescription($_description)
    {
        $this->_description = $_description;
        return $this;
    }
}