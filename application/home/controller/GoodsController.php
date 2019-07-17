<?php

namespace app\home\controller;

use think\Controller;
use app\common\model\Goods;
use app\common\model\GoodsPics;
use app\common\model\Attribute;
use app\common\model\Category;

	/**
    *商品列表
    **/

class GoodsController extends Controller
{
    //列表

    public function index(){
        $data=request()->param();
     //    $goods=Goods::where('cate_id',$data['catId'])->select();
    	// #2.加载视图
    	// return $this->fetch('index',[
     //            'userName'=>$data['userName'],
     //            'goods'=>$goods
     //        ]);
        $categorys=Category::where('is_show',1)->select();
        $cates=Category::select();
        // $id=[];
        $id=[];
        foreach($cates as $onecate)
        {   
            if($onecate->pid == $data['catId']){
                $id[]=$onecate->cat_id;
                foreach($cates as $twocate)
                {
                    if($onecate->cat_id == $twocate->pid){
                        $id[]=$twocate->cat_id;
                   
                    }
                }
            }

        }
         $id[]=$data['catId'];
        // dump($id);die;
        $goods=Goods::select();
        return $this->fetch('index',[
                'categorys'=>$categorys,
                'goods'=>$goods,
                'id'=>$id
            ]);
    }

    //商品详情

    public function detail(){
        $data=request()->param();
        $goods=goods::where('goods_id',$data['goodsId'])->find();
        $goodspics=GoodsPics::where('goods_id',$data['goodsId'])->select();
         $categorys=Category::where('is_show',1)->select();
        $attrs = Attribute::field('attribute.attr_name,goods_attr.goods_id,group_concat(goods_attr.attr_value) as attr_vals,group_concat(goods_attr.id) as goods_attr_id')
        ->join('goods_attr', 'attribute.attr_id=goods_attr.attr_id')
        ->where('goods_attr.goods_id',$data['goodsId'])
        ->group('attribute.attr_name')
        ->select();
    	#3.加载商品详情视图
    	return $this->fetch('detail',[
                'categorys'=>$categorys,
                'goods'=>$goods,
                'goodspics'=>$goodspics,
                'attrs'=>$attrs
            ]);
    }
}
