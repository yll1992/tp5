<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:58:"C:\www\tp5\public/../application/admin\view\index\top.html";i:1558101859;}*/ ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/static/admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/static/admin/js/jquery.js"></script>
    <script type="text/javascript">
    $(function() {
        //顶部导航切换
        $(".nav li a").click(function() {
            $(".nav li a.selected").removeClass("selected")
            $(this).addClass("selected");
        })
    })
    </script>
</head>

<body style="background:url(/static/admin/images/topbg.gif) repeat-x;">
    <div class="topleft">
        <a href="main.html" target="_parent"><img src="/static/admin/images/logo.png" title="系统首页" /></a>
    </div>
    <ul class="nav">
        <li>
            <a href="main.html" target="rightFrame" class="selected"><img src="/static/admin/images/icon01.png" title="首页" />
                <h2>首页</h2></a>
        </li>
        <li>
            <a href="rbac.html" target="rightFrame"><img src="/static/admin/images/icon06.png" title="权限设置" />
                <h2>权限设置</h2></a>
        </li>
    </ul>
    <div class="topright">
        <ul>
            <li><a href="login.html" target="_parent">退出</a></li>
        </ul>
        <div class="user">
            <span>欢迎您，admin</span>
        </div>
    </div>
</body>

</html>
