<?php
namespace Mvc\Form\Entry;
use \Mvc\Form\Entry\EntryAbstract as EntryAbstract;
use \Mvc\Form\Element\ElementAbstrac;
use \stdClass;

class Fieldset extends EntryAbstract
{
    protected $elements = array();
    protected $attributes = null;
    protected $legend = '';
    protected $legendAttributes = null;
    protected $name = '';
    public function __construct()
    {
        $this->attributes = new stdClass();
        $this->legendAttributes = new stdClass();
    }
    public function addElement(\Mvc\Form\Element\ElementAbstract $entry)
    {
        $this->elements[] = $entry;
        return $this;
    }

    public function render()
    {
        $entry = '';
        $entry .= '<fieldset ';
        foreach (get_object_vars($this->attributes) as $name => $value) {
            $entry .= $name . '="' . $value . '" ';
        }
        $entry .= '>' . PHP_EOL;
        if (!empty($this->legend)) {
            $entry .= '<legend ';
            if (count($this->legendAttributes) > 1) {
                foreach (get_object_vars($this->legendAttributes) as $name => $value) {
                    $entry .= $name . '="' . $value . '" ';
                }
            }
            $entry .= '>' . PHP_EOL;
            $entry .= htmlentities($this->legend) . '</legend>';
        }
        foreach ($this->elements as $element) {
            $entry .= $element->render() . PHP_EOL;
        }
        $entry .='</fieldset>';
        return $entry;
    }
    public function getLegend()
    {
        return $this->legend;
    }
    public function setLegend($legend)
    {
        $this->legend = $legend;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function addLegendAttribute($name, $value)
    {
        $this->legendAttributes->$name = $value;
        return $this;
    }
    public function addAttribute($name, $value)
    {
        $this->attributes->$name = $value;
        return $this;
    }
    public function getElements()
    {
        return $this->elements;
    }
}