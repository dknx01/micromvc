<?php
class Form_Abstract
{
    /**
     *
     * @var stdClass
     */
    protected $_formDefinition = null;
    /**
     *
     * @var stdClass
     */
    protected $_formData = null;

    final public function __construct()
    {
        $this->_formDefinition = new stdClass;
        $this->_formData = new stdClass();
        $this->main();
    }

    public function main()
    {
    }

    /**
     *
     * @return Form_Abstract
     */
    public function proceedFormRequest()
    {
        /**
         * @var Helper_Request
         */
        $request = Registry::getInstance()->get('request');
        foreach (get_object_vars($this->getFormDefinition()) as $name => $element) {
            $this->_formData->$name = $request->getParamByName($name);
        }
        return $this;
    }
    /**
     * @return stdClass
     */
    public function getFormDefinition()
    {
        return $this->_formDefinition;
    }
    /**
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

        $this->_formDefinition->$name = $formDefinition;
        return $this;
    }
    /**
     *
     * @return array
     */
    public function checkForm()
    {
        $error = array();
        foreach (get_object_vars($this->getFormDefinition()) as $name => $element) {
            if ($element['optional'] == false) {
                if (!property_exists($this->getFormData(), $name)) {
                    $error[$name]= ' is not set';
                } elseif (empty($this->_formData->$name)) {
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
     * @return the $_formData
     */
    public function getFormData()
    {
        return $this->_formData;
    }

    /**
     * @param stdClass $_formData
     * @return Form_Abstract
     */
    public function setFormData($_formData)
    {
        $this->_formData = $_formData;
        return $this;
    }
    /**
     *
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
        $this->_formData->$name = $value;
        return $this;
    }
}