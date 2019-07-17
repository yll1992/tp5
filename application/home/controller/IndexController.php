<?php

namespace app\home\controller;

use think\Controller;
use app\common\model\Category;
use app\common\model\Goods;

	/**
    *电商首页
    **/

class IndexController extends Controller
{
	//列表
    public function index(){
    	$categorys=Category::where('is_show',1)->select();

    	$hots=Goods::where('is_hot',Goods::YES)->order('created_at desc')->limit(4)->select();
    	$bests=Goods::where('is_best',Goods::YES)->order('created_at desc')->limit(4)->select();
    	$news=Goods::where('is_new',Goods::YES)->order('created_at desc')->limit(4)->select();
        
    	#2.加载视图
    	return $this->fetch('index',[
    			'categorys'=>$categorys,
    			// 'userName'=>$userName,
    			'hots'=>$hots,
    			'bests'=>$bests,
    			'news'=>$news
    		]);
    }
}
