<?php

class Form_Element_SelectList extends Form_Element_Abstract
{
    private $options = array();
    /**
     * @see Form_Element_Abstract
     */
    public function definition()
    {
        $this->setElementType('selectlist');
    }
    public function render()
    {
        $form = '<select ';
        $form .= 'name="' . $this->getName() . '" ';
        $form .= 'id="' . $this->getId() . '" ';
        $form .= 'name="' . $this->getName() . '" ';
        $form .= 'class="' . $this->getClass() . '" ';
        $form .= $this->renderAttributes();
        $form .= '>' . PHP_EOL;
        $form .= $this->proccessOptions();
        $form .=  PHP_EOL . '</select>';
        return $form;
    }
    
    private function proccessOptions()
    {
        $options = '';
        foreach ($this->options as $group => $entry) {
            if ($entry['group'] == false) {
                $options .= $this->proccessOption($entry['options']);
            } elseif($entry['group'] == true) {
                $options .= '<optgroup ';
                $options .= 'label="' . $group . '"';
                $options .= '>' . PHP_EOL;
                $options .= '</optgroup>' . PHP_EOL;
                foreach ($entry['options'] as $option) {
                    $options .= $this->proccessOption($option);
                }
            }
        }
        return $options;
    }
    private function proccessOption($option) {
        $html = '<option';
        $html .= is_null($option['name']) ? '' : ' name="' . $option['name'] . '"';
        $html .= $option['selected'] == true ? ' selected="selected"' : '';
        $html .= '>';
        $html .= $option['value'];
        $html .= '</option>';
        return $html . PHP_EOL;
    }

    public function addOption($value, $name = null, $group = null, $selected = false)
    {
        $option = array(
                'name' => $name,
                'value' => $value,
                'selected' => $selected
                );
        if (is_null($group)) {
            $entry = array(
                        'group' => false,
                        'options' => $option
                    );
            $this->options[] = $entry;
        } else {
             if (array_key_exists($group, $this->options)) {
                 $this->options[$group]['options'][] = $option;
             } else {
                $this->options[$group]['group'] = true;
                $this->options[$group]['options'][] = $option;
             }
        }
        return $this;
    }
}