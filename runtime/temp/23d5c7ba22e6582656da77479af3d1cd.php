<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"C:\www\tp5\public/../application/admin\view\public\login.html";i:1558769314;}*/ ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>欢迎登录京西商城后台管理系统</title>
    <link href="/static/admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/static/admin/js/jquery.js"></script>
    <script src="/static/admin/js/cloud.js" type="text/javascript"></script>
    <script language="javascript">
    $(function() {
        $('.loginbox').css({
            'position': 'absolute',
            'left': ($(window).width() - 692) / 2
        });
        $(window).resize(function() {
            $('.loginbox').css({
                'position': 'absolute',
                'left': ($(window).width() - 692) / 2
            });
        })
    });
    </script>
</head>

<body style="background-color:#1c77ac; background-image:url(/static/admin/images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">
    <div id="mainBody">
        <div id="cloud1" class="cloud"></div>
        <div id="cloud2" class="cloud"></div>
    </div>
    <div class="logintop">
        <span>欢迎使用京西商城后台管理系统</span>
        <ul>
            <li><a href="/" target="_blank">商城首页</a></li>
        </ul>
    </div>
    <form action="" method="post">
        <div class="loginbody">
            <span class="systemlogo"></span>
            <div class="loginbox" style="margin-top: 80px;">
                <ul>
                    <li>
                        <input name="user_name" type="text" class="loginuser" placeholder="用户名" />
                    </li>
                  
                    <li>
                        <input name="user_pwd" type="password" class="loginpwd" placeholder="密码" />
                    </li>
                      <li>
                        <input name="captcha" type="password" class="loginpwd" placeholder="验证码" style="width:50px"/>
                        <img src="<?php echo captcha_src(); ?>" alt="captcha" id="captcha"/>
                        <script>
                                var captchaObj = document.getElementById('captcha');
                                    captchaObj.onclick = function(){
                                        captchaObj.src = '<?php echo captcha_src(); ?>?t=' + (new Date).getTime();
                                    }

                        </script>
                    </li>
                    <li>
                        <input name="" type="submit" class="loginbtn" value="登录" />
                        <label><a href="#">忘记密码？</a></label>
                    </li>
                </ul>
            </div>
        </div>
    </form>
    <div class="loginbm">版权所有 &copy;2016 <a href="http://www.itcast.cn/php">传智播客教育集团 PHP学院</a> </div>
</body>

</html>
