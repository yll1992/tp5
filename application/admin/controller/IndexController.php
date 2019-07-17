<?php

namespace app\admin\controller;

use think\Controller;

class IndexController extends BaseController
{
    //电商后台首页

    public function index(){
    	//显示视图

    	return $this->fetch();
    }

    //头部导航
     public function top(){
    	//显示视图

    	return $this->fetch();
    }


    //左侧导航
     public function left(){
    	//显示视图

    	return $this->fetch();
    }

    //欢迎页
     public function welcome(){
    	//显示视图

    	return $this->fetch();
    }
}
