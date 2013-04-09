<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>

<!-- CSS Files -->
<?php
    if (!is_null(Registry::getInstance()->get('viewHeader'))) {
        echo Registry::getInstance()->get('viewHeader') . PHP_EOL;
    }
?>
</head>
<body>
    <div id="navi">
    </div>
<?php
echo Registry::getInstance()->get('viewContent');
?>
</body>
</html>