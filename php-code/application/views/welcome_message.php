<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>自在家</title>
</head>
<style>
    body {
        position:absolute;
        top:0px;
        left:0px;
        right:0px;
        bottom:0px;
        padding:0;
        margin: 0;
    }
    
    #page {
        height:100%;
    }
</style>
<body>
        <div id="page"></div>
</body>
<script src="<?php echo base_url('/webapp/lib/jquery.js');?>"></script>
 <script>
    $("#page").load("webapp/pages/index.html");
</script>
</html>