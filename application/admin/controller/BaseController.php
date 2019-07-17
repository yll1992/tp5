<?php

namespace app\admin\controller;

use think\Controller;

class BaseController extends Controller
{
    //
    public function __construct(){
    	//切记think\Controller里面有构造函数不能覆盖
		parent::__construct();
		//判断用户是否登录
		if (!\think\Session::get('userinfo')) {
			$this->error('请登录后重试，跳转中...', url('public/login'));
		}
    }
}
