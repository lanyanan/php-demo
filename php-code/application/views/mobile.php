<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>自在家</title>

<link rel="stylesheet" type="text/css" href="http://cdn.amazeui.org/amazeui/1.0.1/css/amazeui.basic.min.css" />
</head>
<body>
<div class="body">
<div class="am-header">
<?php
include ("header.php");
?> 
</div>
<div class="am-search">
<?php
include ("search.php");
?> 
</div>
<div  class="am-submenu">
<?php
include ("menu.php");
?>     
</div>
<div class="content">
<?php
include ("content.php");
?> 
</div>
<div class="am-footer">
<?php
include ("foot.php");
?> 
</div>
	</div>


</body>
</html>