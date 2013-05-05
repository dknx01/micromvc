<?php

abstract class Form_Element_Abstract
{
    protected $elementType = '';
    protected $name = '';
    protected $id = '';
    protected $class = '';
    protected $attributes = null;
    protected $check = null;
    public function __construct()
    {
        $this->attributes = new stdClass();
        $this->check = new Form_Check();
        $this->definition();
    }
    /**
     * define the form element
     */
    abstract function definition();
    /**
     * the elements render function
     */
    abstract function render();
    /**
     * get the type of the form element
     * @return string
     */
    public function getElementType()
    {
        return $this->elementType;
    }
    /**
     * set the type of the form element
     * @param string $elementType
     * @return \Form_Element_Abstract
     */
    public function setElementType($elementType)
    {
        $this->elementType = $elementType;
        return $this;
    }
    /**
     * get the name attribute
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * sett the name attribute
     * @param string $name
     * @return \Form_Element_Abstract
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * get the id attribute
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * set the id attribute
     * @param string $id
     * @return \Form_Element_Abstract
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * get the class attribute
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
    /**
     * get the class attribute
     * @param string $class
     * @return \Form_Element_Abstract
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }
    /**
     * get all additional attributes
     * @return stdClass
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    /**
     * set all additional attributes
     * @param stdClass $attributes
     * @return \Form_Element_Abstract
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }
    /** 
     * @param string $name
     * @param string $value
     * @return \Form_Element_Abstract
     */
    public function addAttribute($name, $value)
    {
        $this->attributes->$name = $value;
        return $this;
    }
    /**
     * get an attribute by its name
     * @param string $name
     * @return string
     */
    public function getAttribute($name)
    {
        return $this->attributes->$name;
    }
    
    protected function renderAttributes()
    {
        $attributes = '';
        foreach ($this->getAttributes() as $key => $value) {
            $attributes .= $key . '="' . $value . '" ';
        }
        return $attributes;
    }
    public function getCheck()
    {
        return $this->check;
    }

    public function setCheck($check)
    {
        $this->check = $check;
        return $this;
    }
    public function check()
    {
        return $this->check->check();
    }
}