<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>自在家(zizaiplus)-自在新奇之美在家里！</title>
<meta name="keywords" content="自在新奇之美在家里,装修案例,装修报价,装修效果图,室内装修,装修视频">
<meta name="description" content="自在新奇之美在家里,装修案例,装修报价,装修效果图,室内装修,装修视频">
<link rel="stylesheet" href="/static/css/login.css"></link>
<head>
	<meta charset="utf-8">
	<title>自在家</title>
</head>
<body>
    <section class="home-login">
        <form class="form" action="<?php echo site_url('/mobile/register'); ?>"  method="POST" name="post提交">
            <div class="username">
                <span>昵称:</span>
                <input name="nickname" type="text"/>
            </div>
            <div class="username">
                <span>用户名:</span>
                <input name="username" type="text"/>
            </div>
            <div class="password"> 
                <span>密码:</span>
                <input name="password" type="password" />
            </div>
            <div class="username">
                <span>性别:</span>
                <input name="usersex" type="text"/>
            </div>
            <div class="username">
                <span>手机:</span>
                <input name="usermobile" type="text"/>
            </div>
            <div class="button" id="register">
                <input type="submit" value="注册" />
            </div>
        </form>
    </section>
</body>
<script src="https://cdn.bootcss.com/jquery/2.1.2/jquery.js"></script>
<script></script>
</html>