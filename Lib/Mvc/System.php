<?php
/**
 * class for system object calls
 *
 * PHP version >=5.3
 *
 * @package Mvc
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc;

class System
{

    /**
     * the instances of called objects
     * @var array
     */
    static private $instances = array();

    /**
     * call an instance of an objec
     *
     * @param string $name object name
     *
     * @return mixed
     */
    static public function getInstance($name)
    {
        $key = \str_replace(array(' ', '\\'), '', $name);
        if (!array_key_exists($key, self::$instances)) {
            if (\class_exists($name)) {
                self::$instances[$key] = new $name();
            }
        }
        return self::$instances[$key];
    }

    /**
     * call an instance of an object.
     * Alisa for getInstance()
     *
     * @param string $name object name
     *
     * @return mixed
     */
    static public function get($name)
    {
        return self::getInstance($name);
    }
}