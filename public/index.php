<?php

error_reporting(E_WARNING);
ini_set('display_errors', '1');
/**
 * my auto loader
 * @param string $classname
 * @throws Exception
 */
function MyAutoloader($classname)
{
    $filename  = realpath(__DIR__)  . '/../Classes/' . str_replace('_', '/', $classname);
    if (file_exists($filename . '.php')) {
        require_once $filename . '.php';
    } else {
        throw new Exception($filename . ' not found');
    }
}
spl_autoload_extensions('.php'); // comma-separated list
spl_autoload_register('MyAutoloader');

$application = new Application();
$application->run();