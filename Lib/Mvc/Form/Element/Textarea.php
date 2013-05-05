<?php

class Form_Element_Textarea extends Form_Element_Abstract
{
    protected $value = '';
    private $cols = 10;
    private $rows = 10;
    /**
     * @see Form_Element_Abstract
     */
    public function definition()
    {
        $this->setElementType('textarea');
    }
    public function render()
    {
        $form = '<textarea ';
        $form .= 'id="' . $this->getId() . '" ';
        $form .= 'name="' . $this->getName() . '" ';
        $form .= 'class="' . $this->getClass() . '" ';
        $form .= $this->renderAttributes();
        $form .= 'cols="' . $this->getCols() . '" ';
        $form .= 'rows="' . $this->getRows() . '" ';
        $form .= '>';
        $form .= $this->getValue();
        $form .= '</textarea>';
        return $form;
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

    public function getCols()
    {
        return $this->cols;
    }

    public function setCols($cols)
    {
        $this->cols = $cols;
        return $this;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }
}