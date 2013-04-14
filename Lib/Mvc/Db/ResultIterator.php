<?php

class Db_ResultIterator implements Iterator
{
    private $position = 0;
    private $items = array();

    public function __construct(array $results) {
        $this->position = 0;
        $this->items = $results;
    }

    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->items[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return array_key_exists($this->position, $this->items);
    }
}