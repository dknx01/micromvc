<?php
/**
 * class to set a form definition and checks it
 * @author dknx01
 * @package Form
 */
abstract class Form_Abstract
{
    /**
     * the form elements
     * @var array
     */
    protected $formElements = array();
    protected $action = '';
    protected $method = 'post';
    protected $attributes = null;
    protected $checkErrors = null;
    /**
     * the constructor
     */
    final public function __construct()
    {
        $this->attributes = new stdClass();
//        $this->formData = new stdClass();
        $this->form();
    }
    /**
     * the form function overwritten in the form definition
     */
    abstract function form();

    /**
     * the form definition
     * @return array
     */
    public function getFormDefinition()
    {
        return $this->formElements;
    }
    /**
     * adds an element to this form
     * @param Form_Element_Abstract $entry
     * @param string|Form_Entry_Fieldset $fieldSet
     * @return \Form_Abstract
     */
    public function addElement(Form_Element_Abstract $element,
                               $fieldSet = null)
    {
        if (!is_null($fieldSet))
        {
            if (array_key_exists($fieldSet, $this->formElements)) {
                if (!($fieldSet instanceof Form_Entry_Fieldset)) {
                    /**
                     * @var $fieldSetEntry Form_Entry_Fieldset
                     */
                    $fieldSetEntry = $this->formElements[$fieldSet];
                    $fieldSetEntry->addElement($element);
                    $this->formElements[$fieldSet] = $fieldSetEntry;
                } else {
                    throw new Exception ('Cannot add an element to a fieldset '
                        . 'that is of type Form_Entry_Fieldset');
                }
            } else {
                if ($fieldSet instanceof Form_Entry_Fieldset) {
                    $this->formElements[$fieldSet->getName()] = $fieldSet;
                } else {
                    $fieldSetEntry = new Form_Entry_Fieldset();
                    $fieldSetEntry->setName($fieldSet);
                    $fieldSetEntry->addElement($element);
                    $this->formElements[$fieldSet] = $fieldSetEntry;
                }
            }
            
        } else {
            $this->formElements[] = $element;
        }
        
        return $this;
    }
    
    public function render()
    {
        $form = PHP_EOL . '<form ';
        $form .= 'action="' . $this->getAction() . '" ';
        $form .= 'method="' . $this->getMethod() . '" ';
        foreach (get_object_vars($this->getAttributes()) as $name => $value) {
            $form .= $name . '="' . $value . '" ';
        }
        $form .= '>' . PHP_EOL;
        foreach ($this->formElements as $element) {
            $form .= $element->render() . PHP_EOL;
        }
        $form .= PHP_EOL . '</form>' . PHP_EOL;
        return nl2br($form);
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
    public function getFormData()
    {
        return $this->formData;
    }

    public function setFormData(stdClass $formData)
    {
        $this->formData = $formData;
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }
    public function check($recheck = false)
    {
        if (is_null($this->checkErrors) || $recheck == true) {
            $this->checkErrors = new Form_Check_Error();
            foreach ($this->formElements as $element) {
               if ($element instanceof Form_Entry_Fieldset) {
                   foreach ($element->getElements() as $entry) {
                       $check = $entry->check();
                       if (($check != true) == false) {
                           $this->checkErrors->addError($entry->getName(), $check);

                       }
                   }
               } else {
                   $check = $element->check();
                   if ($check != true) {
                       $this->checkErrors->addError($element->getName(), $check);
                   }
               }
            }
        }
        return $this->checkErrors;
    }
}