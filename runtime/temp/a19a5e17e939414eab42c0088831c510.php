<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:59:"C:\www\tp5\public/../application/admin\view\index\left.html";i:1559006989;}*/ ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/static/admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/static/admin/js/jquery.js"></script>
    <script type="text/javascript">
    $(function() {
        //导航切换
        $(".menuson li").click(function() {
            $(".menuson li.active").removeClass("active")
            $(this).addClass("active");
        });
 
        $('.title').click(function() {
            var $ul = $(this).next('ul');
            $('dd').find('ul').slideUp();
            if ($ul.is(':visible')) {
                $(this).next('ul').slideUp();
            } else {
                $(this).next('ul').slideDown();
            }
        });
    })
    </script>
</head>

<body style="background:#f0f9fd;">
    <div class="lefttop"><span></span>※ MENU ※</div>
    <dl class="leftmenu">
        <dd>
            <div class="title">
                <span><img src="/static/admin/images/leftico01.png" /></span>商品管理
            </div>
            <ul class="menuson">
                <li class="active">
                    <cite></cite><a href="<?php echo url('Goods/index'); ?>" target="rightFrame">商品列表</a><i></i>
                </li>
                <li>
                    <cite></cite><a href="<?php echo url('Goods/add'); ?>" target="rightFrame">添加商品</a><i></i>
                </li>
            </ul>
        </dd>
        <dd>
            <div class="title"><span><img src="/static/admin/images/leftico03.png" /></span>商品分类</div>
            <ul class="menuson">
                <li>
                    <cite></cite><a href="<?php echo url('category/index'); ?>" target="rightFrame">分类列表</a><i></i>
                </li>
                <li>
                    <cite></cite><a href="<?php echo url('category/add'); ?>" target="rightFrame">分类添加</a><i></i>
                </li>
            </ul>
        </dd>
        <dd>
            <div class="title"><span><img src="/static/admin/images/leftico03.png" /></span>商品类型</div>
            <ul class="menuson">
                <li>
                    <cite></cite><a href="<?php echo url('type/index'); ?>" target="rightFrame">类型列表</a><i></i>
                </li>
                <li>
                    <cite></cite><a href="<?php echo url('type/add'); ?>" target="rightFrame">类型添加</a><i></i>
                </li>
            </ul>
        </dd>
        <dd>
            <div class="title"><span><img src="/static/admin/images/leftico04.png" /></span>商品属性</div>
            <ul class="menuson">
                <li>
                    <cite></cite><a href="<?php echo url('attr/index'); ?>" target="rightFrame">属性列表</a><i></i>
                </li>
                <li>
                    <cite></cite><a href="<?php echo url('attr/add'); ?>" target="rightFrame">属性添加</a><i></i>
                </li>
            </ul>
        </dd>
        <dd>
            <div class="title">
                <span><img src="/static/admin/images/leftico02.png" /></span>订单管理
            </div>
            <ul class="menuson">
                <li><cite></cite><a href="./订单列表.html"  target="rightFrame">订单列表</a><i></i></li>
            </ul>
        </dd>
        <dd>
            <div class="title"><span><img src="/static/admin/images/leftico04.png" /></span>用户管理</div>
            <ul class="menuson">
                <li><cite></cite><a href="<?php echo url('user/index'); ?>" target="rightFrame">用户列表</a><i></i></li>
                <li><cite></cite><a href="<?php echo url('user/add'); ?>" target="rightFrame">用户添加</a><i></i></li>
            </ul>
        </dd> 
        <dd>
            <div class="title"><span><img src="/static/admin/images/leftico04.png" /></span>角色管理</div>
            <ul class="menuson">
                <li><cite></cite><a href="<?php echo url('Role/index'); ?>" target="rightFrame">角色列表</a><i></i></li>
                <li><cite></cite><a href="<?php echo url('Role/add'); ?>" target="rightFrame">角色添加</a><i></i></li>
            </ul>
        </dd> 
        <dd>
            <div class="title"><span><img src="/static/admin/images/leftico04.png" /></span>权限管理</div>
            <ul class="menuson">
                <li><cite></cite>
                    <a href="<?php echo url('auth/index'); ?>" target="rightFrame">权限列表</a><i></i>
                </li>
                <li><cite></cite>
                    <a href="<?php echo url('auth/add'); ?>" target="rightFrame">权限添加</a><i></i>
                </li>
            </ul>
        </dd>
    </dl>
</body>

</html>
