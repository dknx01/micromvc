<?php
/**
 * application autoloader
 * @param string $classname
 */
function AppAutoloader($classname)
{
    $filename  = APPDIR . '/' . str_replace('_', '/', $classname);
    if (file_exists($filename . '.php')) {
        require_once $filename . '.php';
    }
}

/**
 * mvc autoloader
 * @param string $classname
 */
function MvcAutoloader($classname)
{
    $filename  = realpath(__DIR__)  . '/' . str_replace('_', '/', $classname);
    if (file_exists($filename . '.php')) {
        require_once $filename . '.php';
    }
}
/**
 * external Libs autoloader
 * @param string $classname
 */
function LibAutoloader($classname)
{
    $filename  = ROOTDIR  . '/Lib/Libs/' . str_replace('_', '/', $classname);
    if (file_exists($filename . '.php')) {
        require_once $filename . '.php';
    }
}
spl_autoload_extensions('.php'); // comma-separated list
spl_autoload_register('MvcAutoloader');
spl_autoload_register('AppAutoloader');
spl_autoload_register('LibAutoloader');