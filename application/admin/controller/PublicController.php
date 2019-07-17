<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\User;
use think\Session;

//电商后台（admin）
class PublicController extends Controller
{
    //登录页
    public function login(){
    	if(request()->isPost()){
    		$postData=request()->param();
    		$validate=$this->validate($postData,'User.login',[]);
    		if($validate !== true){
    			$this->error($validate);
    		}
    		$user=User::where('user_name',$postData['user_name'])->find();
    		if(!$user){
    			$this->error('用户不存在');
    		}
    		if(md5($postData['user_pwd'].'itcast!@#') !== $user->user_pwd){
    			$this->error('用户名或密码错误');
    		}
    		Session::set('userinfo',$user);
    		$this->success('登录成功',url('index/index'));
    	}else{
    		//显示视图

    	return $this->fetch();
    	}
    	
    }
}
