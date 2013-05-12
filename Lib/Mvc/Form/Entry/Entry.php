<?php
namespace Mvc\Form\Entry;
use \Mvc\Form\Entry\EntryAbstract as EntryAbstract;
use \Mvc\Form\Element\ElementAbstract as ElementAbstract;
use \Mvc\Form\Check as CheckClass;

class Entry extends EntryAbstract
{
    protected $element = null;
    protected $check = null;
    public function __construct(ElementAbstract $element, CheckClass $check)
    {
        $this->element = $element;
        $this->check = $check;
    }

    public function render()
    {
        $entry = '';
        if ($this->element instanceof ElementAbstract 
            && method_exists($this->element, 'render')
        ){
            $entry .= $entry->render() . PHP_EOL;
        }
        return $entry;
    }
}