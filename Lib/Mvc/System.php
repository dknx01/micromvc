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
use \stdClass;

class System
{
    /**
     * our store
     * @var \stdClass
     */
    protected $store = null;
    /**
     * the instances of called objects
     * @var array
     */
    static private $instance = null;

    /**
     * get the current registry or create a new one
     * @return \Mvc\System
     */
    static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * the constructor
     */
    public function __construct()
    {
        $this->store = new stdClass();
        $this->store->viewHeader = '';
        $this->store->viewContent = '';
        $this->store->viewFooter = '';
        $this->store->viewDoctype = '';
        $this->store->request = null;
        $this->store->database = null;
        $this->store->serviceLocator = null;
    }

    /**
     * gets a value from our store
     * @param string $name
     * @throws Exception
     * @return null|mixed
     */
    public function get($name)
    {
        if (property_exists($this->store, $name)) {
            return $this->store->$name;
        } else {
            return null;
        }
    }

    /**
     * set a new entry in the store
     * @param string $name
     * @param mixed $value
     * @return \Mvc\System
     */
    public function set($name, $value)
    {
        if (property_exists($this, $name)) {
           error_log( 'Entry ' .  $name . ' will be overwritten');
        }
        $this->store->$name = $value;
        return $this;
    }
    /**
     * set or get the view header data
     * 
     * @param string $data the view data or null
     * 
     * @return string
     */
    public function viewHeader($data = null)
    {
        if (!is_null($data)) {
            $this->store->viewHeader = $data;
        }
        return $this->store->viewHeader;
    }
    /**
     * set or get the view footer data
     * 
     * @param string $data the view data or null
     * 
     * @return string
     */
    public function viewFooter($data = null)
    {
        if (!is_null($data)) {
            $this->store->viewFooter = $data;
        }
        return $this->store->viewFooter;
    }
    /**
     * set or get the view content data
     * 
     * @param string $data the view data or null
     * 
     * @return string
     */
    public function viewContent($data = null)
    {
        if (!is_null($data)) {
            $this->store->viewContent = $data;
        }
        return $this->store->viewContent;
    }
    /**
     * set or get the view doctype data
     * 
     * @param string $data the view data or null
     * 
     * @return string
     */
    public function viewDoctype($data = null)
    {
        if (!is_null($data)) {
            $this->store->viewDoctype = $data;
        }
        return $this->store->viewDoctype;
    }
    /**
     * get the request object
     * 
     * @return \Mvc\Helper\Request
     */
    public function getRequest()
    {
        if (is_null($this->store->request)) {
            $this->store->request = new \Mvc\Helper\Request();
        }
        return $this->store->request;
    }
    /**
     * get or set the database adapter
     * 
     * @param \Mvc\Db\Adapter $data a new database connection or null
     * 
     * @return \Mvc\Db\Adapter
     */
    public function database($data = null)
    {
        if (!is_null($data)) {
            $this->store->database = $data;
        }
        return $this->store->database;
    }
    /**
     * get or set a service locator
     * 
     * @param \Mvc\Di\ServiceLocator $locator a new service locator
     * 
     * @return \Mvc\Di\ServiceLocator
     */
    public function serviceLocator(\Mvc\Di\ServiceLocator $locator = null)
    {
        if (!is_null($locator)) {
            $this->store->serviceLocator = $locator;
        } elseif (is_null($this->store->serviceLocator)) {
            $this->store->serviceLocator = new \Mvc\Di\ServiceLocator();
        }
        return $this->store->serviceLocator;
    }
}