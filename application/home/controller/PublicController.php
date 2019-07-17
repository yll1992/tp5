<?php

namespace app\home\controller;

use think\Controller;
use app\common\model\User;
use app\common\model\Cart;
use think\Session;

	
class PublicController extends Controller
{
    
	//登录页
    public function login(){
        if(request()->isPost()){
            $postData=request()->param();
            $validate=$this->valiDate($postData,'User',[]);
            if($validate !==true){
                $this->error($validate);
            }
            // $user=User::where('user_name',$postData['user_name'])->find();
            // if(!$user){
            //     $this->error('用户不存在');
            // }
            // if(md5($postData['user_pwd'].'itcast!@#') !== $user->user_pwd){
            //     $this->error('用户名或密码错误');
            // }
            // Session::set('userinfo',$user);
            $sr=User::checkUser($postData,'frontUserinfo');
            
            // $rs=Session::get('frontUserinfo')->user_name;
            if($sr){
                Cart::cookieTodb();
                $url=session('backurl')?session('backurl'):url('index/index');
                $this->success('登录成功',$url);
            }else{
                $this->error('登录失败');
            }
        }else{
            //显示视图

        return $this->fetch();
        }
    	
    }


    //注册页
    public function register(){
    	//显示视图
        

    	return $this->fetch();
    }

    //短信注册
    public function sms($phone){
        // sendSms('17756503403','6666');
        dump($phone);
        $sms=sendSms($phone,'6666');
        if($sms == true){

            return json(['status'=>true,'msg'=>'短信发送成功']);
        }else{
            return json(['status'=>false,'msg'=>'短信发送失败']);
        }
    }
}
