<?php
/**
 * the abstract class for all form entries
 * @author dknx01
 * @package Mvc\Form
 */

namespace Mvc\Form\Entry;

abstract class EntryAbstract
{
    /**
     * renders the entry
     * @return string
     */
    abstract function render();
}