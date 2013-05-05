<?php

class Form_Element_Input extends Form_Element_Abstract
{
    /**
     * the input type
     * @var string
     */
    private $type = 'text';
    private $value = '';
    /**
     * @see Form_Element_Abstract
     */
    public function definition()
    {
        $this->setElementType('input');
    }
    public function render()
    {
        $form = '<input ';
        $form .= 'type="' . $this->getType() . '" ';
        $form .= 'id="' . $this->getId() . '" ';
        $form .= 'name="' . $this->getName() . '" ';
        $form .= 'class="' . $this->getClass() . '" ';
        $form .= $this->renderAttributes();
        $form .= 'value="' . $this->getValue() . '" ';
        $form .= '/>';
        return $form;
    }

    /**
     * get the input type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * set the input type
     * @param string $type
     * @return \Form_Element_Input
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}