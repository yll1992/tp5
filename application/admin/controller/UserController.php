<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\User;
use app\common\model\Role;

class UserController extends BaseController
{
    //

    public function index(){
    	$users=User::join('role','user.role_id=role.role_id','left')->paginate(5);
        // $users=User::with('role')->paginate(2);
        // die;

    	return $this->fetch('index',[
    			'users'=>$users
    		]);
    }

    public function add(){
        if(request()->isPost()){
            $postData=request()->param();
            $validate=$this->validate($postData,'User.add',[]);
            if($validate !==true){
                $this->success($validate);
            }
            unset($postData['user_pwd2']);
            $postData['user_pwd']=md5($postData['user_pwd']."itcast!@#");
            $sr=User::create($postData);
            if($sr){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $roles=Role::select();
            echo 666;
            return $this->fetch('add',[
                'roles'=>$roles
            ]);
        }
    	
    }
}
