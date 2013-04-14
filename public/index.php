<?php
error_reporting(E_WARNING);
ini_set('display_errors', '1');
define('APPDIR', realpath(__DIR__ . '/../Application/'));
define('ROOTDIR', realpath(__DIR__ . '/../'));
require_once ROOTDIR . '/Lib/Mvc/Prepare.php';
require_once ROOTDIR . '/Lib/Mvc/Autoloader.php';
if(APPDIR == false || ROOTDIR == false) {
    throw new Exception ('Cannot find application directory or root directory');
    exit;
}

$application = new Application();
$application->run();