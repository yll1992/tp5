<?php

namespace app\home\controller;

use think\Controller;
use app\common\model\Category;

class UserController extends Controller
{
    //会员中心-家 
    public function home(){
    	//显示视图
          $categorys=Category::where('is_show',1)->select();
    	return $this->fetch('home',[
                'categorys'=>$categorys
            ]);
    }


    //会员中心-我的订单
    public function myorder(){
    	//显示视图
          $categorys=Category::where('is_show',1)->select();
    	return $this->fetch('myorder',[
                'categorys'=>$categorys
            ]);
    }


    //会员中心-收获地址
    public function address(){
    	//显示视图
        $categorys=Category::where('is_show',1)->select();
    	return $this->fetch('address',[
                'categorys'=>$categorys
            ]);
    }
}
