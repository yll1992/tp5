<?php

namespace app\home\controller;

use think\Controller;
use app\common\model\Order;
use app\common\model\Alipay;

class AlipayController extends Controller
{
    //

    public function pay($token){
    	
    	if(!session('frontUserinfo')){
    		$this->error('请登录.....',url('public/login'));
    	}
    	$orders=Order::where('order_id',$token)->find();

    	if(!$orders){
    		$this->error('订单不存在',url('index/index'));
    	}

    	if($orders->order_status == Order::ORDER_STATUS_YES){
    		$this->error('请勿重复支付');
    	}
    	if($orders['order_pay'] == 0){
    		$zfb=Alipay::zfb($orders);
    		}
    	
	}

	public function return_url(){
				/* *
		 * 功能：支付宝页面跳转同步通知页面
		 * 版本：2.0
		 * 修改日期：2017-05-01
		 * 说明：
		 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

		 *************************页面功能说明*************************
		 * 该页面可在本机电脑测试
		 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
		 */
		// require_once("config.php");
		// require_once 'pagepay/service/AlipayTradeService.php';

		require_once EXTEND_PATH . '/alipay/config.php';
		require_once EXTEND_PATH . '/alipay/pagepay/service/AlipayTradeService.php';


		$arr=$_GET;
		$alipaySevice = new \AlipayTradeService($config); 
		$result = $alipaySevice->check($arr);

		/* 实际验证过程建议商户添加以下校验。
		1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
		2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
		3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
		4、验证app_id是否为该商户本身。
		*/
		if($result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

			//商户订单号
			$out_trade_no = htmlspecialchars($_GET['out_trade_no']);
			#1.判断用户是否登录
			if(!session('frontUserinfo')) $this->error('请登录.....',url('public/login'));
			#2.获取订单信息
			$order=Order::where('order_number',$out_trade_no)->find();
			if(!$order) $this->error('你的操作有误，请稍后再试',url('index/index'));
			if($order->order_status == Order::ORDER_STATUS_YES) $this->success('支付成功',url('user/order'));
			#4.修改状态
			$sr=Order::where('order_number',$out_trade_no)->update([
					'order_status'=>Order::ORDER_STATUS_YES
				]);

			if($sr){
				$this->success('支付成功',url('user/order'));
			}else{
				//TODO.支付失败发送邮件报警
				$title='支付失败';
				$content=$sr;
				$address='tsgioern@163.com';
				$email=sendEmail($title,$content,$address);
				$this->error('支付失败',url('order/pay', ['token'=>$order->order_id]));
			}
			//支付宝交易号
			// $trade_no = htmlspecialchars($_GET['trade_no']);
				
			// echo "验证成功<br />支付宝交易号：".$trade_no;

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
		    //验证失败
		    echo "验证失败";
		}
			}
}
