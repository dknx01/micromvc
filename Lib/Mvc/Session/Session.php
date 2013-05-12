<?php
/**
 * class for session data hanndling
 * @author dknx01
 * @package Mvc\Session
 */
namespace Mvc\Session;
use \stdClass;

class Session
{
    /**
     * creates a new session or returns an existing one
     * @param string $name
     * @return stdClass
     * @throws Exception
     */
    public function __construct($name = 'Default')
    {
        if (empty($name)) {
            throw new Exception ('Session needs a name');
        }   
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        } else {
            $_SESSION[$name] = new stdClass();
        }
    }
}