<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../Lib/Mvc/Autoloader.php';
define('APPDIR', realpath(__DIR__ . '/../Application/'));
define('ROOTDIR', realpath(__DIR__ . '/../'));

if(APPDIR == false || ROOTDIR == false) {
    throw new Exception ('Cannot find application directory or root directory');
    exit;
}
$application = new Application();
$application->run();