<?php
/**
 * define a html textarea element
 * @author dknx01
 * @package Form\Element
 */
class Form_Element_Textarea extends Form_Element_Abstract
{
    /**
     * the value
     * @var string
     */
    protected $value = '';
    /**
     * width in columns
     * @var int
     */
    private $cols = 10;
    /**
     * height in rows
     * @var int
     */
    private $rows = 10;
    /**
     * @see Form_Element_Abstract
     */
    public function definition()
    {
        $this->setElementType('textarea');
    }
    /**
     * @see Form_Element_Abstract
     * @return string
     */
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
    /**
     * returns the value
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * set the value data
     * @param string $value
     * @return \Form_Element_Textarea
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    /**
     * returns the width
     * @return int
     */
    public function getCols()
    {
        return $this->cols;
    }
    /**
     * set the width
     * @param int $cols
     * @return \Form_Element_Textarea
     */
    public function setCols($cols)
    {
        $this->cols = $cols;
        return $this;
    }
    /**
     * return the height
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }
    /**
     * set the height
     * @param int $rows
     * @return \Form_Element_Textarea
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }
}