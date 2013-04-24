<?php
/**
 * class to set a form definition and checks it
 * @author dknx01
 * @package Form
 */
class Form_Abstract
{
    /**
     * the form definition
     * @var stdClass
     */
    protected $formDefinition = null;
    /**
     * the form data get by a request
     * @var stdClass
     */
    protected $formData = null;
    /**
     * the constructor
     */
    final public function __construct()
    {
        $this->formDefinition = new stdClass;
        $this->formData = new stdClass();
        $this->main();
    }
    /**
     * the main function overwritten in the form definition
     */
    public function main()
    {
    }

    /**
     * set all form data to its request parameters
     * @return Form_Abstract
     */
    public function proceedFormRequest()
    {
        /**
         * @var Helper_Request
         */
        $request = Registry::getInstance()->get('request');
        foreach (get_object_vars($this->getFormDefinition()) as $name => $element) {
            $this->formData->$name = $request->getParamByName($name);
        }
        return $this;
    }
    /**
     * the form definition
     * @return stdClass
     */
    public function getFormDefinition()
    {
        return $this->formDefinition;
    }
    /**
     * adds an entry to the form definition
     * @param string $name
     * @param array $formDefinition
     * @return Form_Abstract
     */
    public function addFormDefinition($name, $formDefinition = array())
    {
        if (!is_array($formDefinition)) {
            throw new Exception('Form definition must be an array');
        }

        if (!array_key_exists('optional', $formDefinition)
            || !in_array($formDefinition['optional'], array(true, false))
        ) {
            $formDefinition['optional'] = false;
        }

        $this->formDefinition->$name = $formDefinition;
        return $this;
    }
    /**
     * checks the form
     * @return array
     */
    public function checkForm()
    {
        $error = array();
        foreach (get_object_vars($this->getFormDefinition()) as $name => $element) {
            if ($element['optional'] == false) {
                if (!property_exists($this->getFormData(), $name)) {
                    $error[$name]= ' is not set';
                } elseif (empty($this->formData->$name)) {
                    $error[$name] = 'is needed and can not be empty';
                } elseif (array_key_exists('function', $element)) {
                    if (method_exists($this, $element['function'])) {
                        $fncName = $element['fucntion'];
                        if ($this->$fncName() == false) {
                            $error[$name] = ' Function' . htmlentities($element['function']) . ' not successfull.';
                        }
                    } else {
                        $error[$name] = ' Function ' . htmlentities($element['function']) . ' not found in form';
                    }
                }
            }
        }

        return $error;
    }
    /**
     * get the passed form data
     * @return the $_formData
     */
    public function getFormData()
    {
        return $this->formData;
    }

    /**
     * set the passed form data
     * @param stdClass $_formData
     * @return Form_Abstract
     */
    public function setFormData($_formData)
    {
        $this->formData = $_formData;
        return $this;
    }
    /**
     * add an entry to the passed form data
     * @param string $name
     * @param mixed $value
     * @throws Exception
     * @return Form_Abstract
     */
    public function addFormData($name, $value = null)
    {
        if (empty($name)) {
            throw new Exception('Form element name must not be empty.');
        }
        $this->formData->$name = $value;
        return $this;
    }
}