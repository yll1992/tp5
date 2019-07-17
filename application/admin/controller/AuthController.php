<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Auth;
use app\common\model\Role;

class AuthController extends BaseController
{
    //
   	public function index(){
   		$auths=Auth::select();
   		return $this->fetch('index',[
   				'auths'=>$auths
   			]);
   	}

   	public function add(){
   		if(request()->isPost()){
   			$postData=request()->param();
   			 $validate=$this->validate($postData,'Auth',[]);
            if($validate !==true){
                $this->success($validate);
            }
           
            
            $sr=Auth::create($postData);
            if($sr){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
   		}else{
   			$auths=Auth::select();
   			return $this->fetch('add',[
   				'auths'=>$auths
   			]);
   		}
   		
   	}
}
