<?php

namespace app\home\controller;

use think\Controller;
use app\common\model\Cart;
use app\common\model\Category;
use app\common\model\Address;

	/**
    *购物车
    **/

class CartController extends Controller
{
    //

    public function index(){
    	$categorys=Category::where('is_show',1)->select();
    	$carts=Cart::getCart();
    		//显示视图
    	return $this->fetch('index',[
    			'categorys'=>$categorys,
    			'carts'=>$carts
    		]);
    	
    	
    }

    public function add(){
    	if(request()->isPost()){
    		$postData=request()->param();
    		$validate=$this->validate($postData,'Cart',[]);

    		if($validate !== true){
    			$this->error($validate);
    		}
    		$sr=Cart::addCart($postData['goods_id'], $postData['goods_number'],$postData['goods_attr_ids']);
    		if($sr){

    			$this->success('添加成功',url('Cart/index'));
    		}else{
    			$this->error('添加失败');
    		}
    	}else{
    		$this->error('你迷路了，正在跳转...',url('index/index'));
    	}
    } 


    //修改商品数量
    public function changeNum(){
        #1.判断数据提交方式
      if(request()->isPost()){
        #2.接收数据
        $postData=request()->param('data/a');
        #3.过滤
        $validate=$this->validate($postData,'Cart',[],true);
        if($validate !== true){
                return json(['status'=>false, 'msg'=>$validate]);
            }
        #4.入库（修改）
        $sr=Cart::updateNum($postData['goods_id'],$postData['goods_attr_ids'],$postData['goods_number']);
        #5.判断返回
        if($sr){
            return json(['status'=>true,'msg'=>'修改成功']);
        }else{
            return json(['status'=>false,'msg'=>'修改失败']);
        }
       }
       else
       {

        $this->error('你迷路了，正在跳转...',url('index/index'));
      }
    }


    // 删除购物车里的商品
    public function delete(){
        #1.判断数据提交方式
        // dump(666);die;
        if(request()->isPost()){
            #2.接收数据
            $postData=request()->param('data/a');
            #3.过滤
            $validate=$this->validate($postData,'Cart.delete',[]);
            if($validate !== true){
                return json(['status'=>false, 'msg'=>$validate]);
            }
            #4.入库（删除）
            $sr=Cart::deleteCart($postData['goods_id'],$postData['goods_attr_ids']);
            #5.判断（return 值）
            if($sr){
                 return json(['status'=>true,'msg'=>'修改成功']);
            }else{
                return json(['status'=>false,'msg'=>'修改失败']);
            }
        }else{
           $this->error('你迷路了，正在跳转...',url('index/index')); 
        }
    }

       // 结算页
      public function checkout(){
          if(!session('frontUserinfo')){
                session('backurl','home/cart/checkout');
                $this->error('请登录，跳转中...',url('public/login'));
            }
        if(request()->isPost()){
          $postData=request()->param();
          // $postData=explode(',', $postData['cart_id']);
        // 检查库存
        $checkNumberRs=Cart::checkNumber($postData);
        if($checkNumberRs !== true){
            $this->error($checkNumberRs);
        }
        $categorys=Category::where('is_show',1)->select();
        $address=Address::where('user_id',session('frontUserinfo.user_id'))->select();
        $carts=Cart::getCart();
        $postData=explode(',', $postData['cart_id']);
        // 购物车中的商品不是全部购买，所以需要过滤
        $datas=[];
        foreach($carts as $cart){
            foreach($postData as $key=>$post){
                if($cart->cart_id == $post){
                    array_push($datas, $cart);
                }
            }
        }
        // dump($datas);
        return $this->fetch('checkout',[
                'categorys'=>$categorys,
                'address'=>$address,
                'datas'=>$datas
            ]); 
    }else{
        $this->error('你迷路了，正在跳转...',url('index/index'));
    }
     
      }

}
