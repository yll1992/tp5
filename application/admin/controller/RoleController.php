<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Role;
use app\common\model\Auth;

class RoleController extends BaseController
{
    //

    public function index(){
    	$roles=Role::select();
    	return $this->fetch('index',[
    			'roles'=>$roles
    		]);
    }

    public function assignAuth($roleId){
        if(request()->isPost()){
            $postData=request()->post();
            $sr=Role::assignAuth($postData['authIds'],$roleId);
            if($sr){
                $this->success('添加成功',url('Role/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $roles=Role::where('role_id',$roleId)->find();
            $auths=Auth::select();
            $role=Role::where('role_id',$roleId)->column('role_auth_ids');
            $role=implode(',',$role);
            $role=explode(',',$role);
            return $this->fetch('assignauth',[
                    'roles'=>$roles,
                    'auths'=>$auths,
                    'role'=>$role
                ]); 
        }
    
    }

    public function add(){
        if(request()->isPost()){
            $postData=request()->param();
            $validate=$this->validate($postData,'Role',[]);
            if($validate !== true){
                $this->error($validate);
            }
            $sr=Role::create($postData);
            if($sr){
                 $this->success('添加成功',url('Role/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            return $this->fetch();
        }
        
    }
}
