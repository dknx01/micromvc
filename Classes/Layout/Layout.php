<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Spacetree - Tree Animation</title>

<!-- CSS Files -->
<link type="text/css" href="css/base.css" rel="stylesheet" />
<link type="text/css" href="css/ForceDirected.css" rel="stylesheet" />
<link type="text/css" href="css/site.css" rel="stylesheet" />
<!-- <script language="javascript" type="text/javascript" src="/site.js"></sscript> -->
<!--[if IE]><script language="javascript" type="text/javascript" src="../../Extras/excanvas.js"></script><![endif]-->

<!-- JIT Library File -->
<script language="javascript" type="text/javascript" src="/Jit/jit.js"></script>

<?php if (Registry::getInstance()->get('asTree') == true) {?>
    <script language="javascript" type="text/javascript" src="example.js"></script>
<script type="text/javascript"> var json = <?php echo Registry::getInstance()->get('treeVis');?> ;</script>
<?php } else {?>
    <script language="javascript" type="text/javascript" src="example_net.js"></script>
<script type="text/javascript"> var json = <?php echo Registry::getInstance()->get('netVis');?> ;</script>
<?php } ?>

<?php
    if (!is_null(Registry::getInstance()->get('viewHeader'))) {
        echo Registry::getInstance()->get('viewHeader') . PHP_EOL;
    }
?>
</head>
<body onload="init();">
    <div id="navi">
        <a href="/">Home</a> <a href="?Input/">Systeme verwalten</a>
    </div>
<?php
echo Registry::getInstance()->get('viewContent');
?>
</body>
</html>