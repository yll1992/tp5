<?php

namespace app\home\controller;

use think\Controller;
use app\common\model\Cart;
use think\Db;
use app\common\model\OrderGoods;
use app\common\model\Order;
use app\common\model\Goods;
use app\common\model\Category;

class OrderController extends Controller
{
    //订单支付

    public function pay($token){
    	$orders=Order::where('order_id',$token)->find();
    	$categorys=Category::where('is_show',1)->select();
    	return $this->fetch('pay',[
    			'categorys'=>$categorys,
    			'orders'=>$orders
    		]);
    }

    public function add(){
    	if(request()->isPost()){
    		$postData=request()->param();
    		  // 检查库存
	        $checkNumberRs=Cart::checkNumber($postData['cartId']);
	        if($checkNumberRs !== true){
	            $this->error($checkNumberRs);
       		}
    		$carts=Cart::getCart();
	        $cartId=explode(',', $postData['cartId']);
	        // 购物车中的商品不是全部购买，所以需要过滤
	        $orders=[];
	        foreach($carts as $cart){
	            foreach($cartId as $key=>$v){
	                if($cart->cart_id == $v){
	                    array_push($orders, $cart);
	                }
	            }
	        }
			// 启动事务
			Db::startTrans();
			try{
			    // Db::table('think_user')->find(1);
			    // Db::table('think_user')->delete(1);
			    $rs=Order::create([
			    	'user_id'=>session('frontUserinfo.user_id'),
			    	'order_number'=>'SH'. date('YmdHis', time()) . mt_rand(1000, 9999),
			    	'order_price'=>Cart::getPriceTotal($postData['cartId']),
			    	'order_status'=>Order::ORDER_PAY_NO,
			    	 //支付方式:0-支付宝,1-微信,2-银行卡快捷支付
                    'order_pay' => $postData['order_pay'],
			    	]);
			    if (!$rs) throw new \Exception("主表插入失败");
			    foreach($orders as $order){
			    	$temp=OrderGoods::create([
			    			'order_id'=>$rs->user_id,
			    			'goods_id'=>$order->goods_id,
			    			'title' =>  $order->goodsinfo->goods_name,
	                        'goods_price' => $order->goodsinfo->goods_price,
	                        'goods_number' => $order->goods_number

			    		]);
			    	if (!$temp) throw new \Exception("主表插入失败"); 
			   		$temp2=Goods::where('goods_id',$order->goods_id)->setDec('goods_number',$order->goods_number);
			   		if (!$temp2) throw new \Exception("库存不足");
			    }
			   
			    // 提交事务
			    Db::commit();
			    //删除商品
			    Cart::truncateCart($postData['cartId']);    
			} catch (\Exception $e) {
			    // 回滚事务
			    Db::rollback();
			    // $this->error($e->getMessage());
			    echo dump($e->getMessage());die;
			}
    	}else{
    		 $this->error('你迷路了，正在跳转...',url('index/index'));
    	}
    	 	#4.跳转（下单成功）
            $this->success('提交订单成功，跳转中...', url('order/pay', ['token'=>$rs->order_id]));
    }
}
