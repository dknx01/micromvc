<?php
/**
 * some prepare work for the mvc application
 */

function checkConstants()
{
    if (!defined('APPDIR')) {
        throw new Exception('APPDIR not defined.');
        exit;
    }
    if (!defined('ROOTDIR')) {
        throw new Exception('ROOTDIR not defined.');
        exit;
    }
}

function setArgSeparator()
{
    ini_set('arg_separator.output', '|');
}

checkConstants();
require_once ROOTDIR . '/Lib/Mvc/php_error.php';
$options = array('background_text' => 'MVC', 'application_root' => ROOTDIR);
\php_error\reportErrors($options);
setArgSeparator();