<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Type;
use think\Validate;


// 1、类型列表功能
class TypeController extends BaseController
{
    //
    public function index(){
    	#显示视图
    	$types=Type::select();
    	// dump($types);
    	return $this->fetch('index',[
    			'types'=>$types
    		]);
    }

    // 2、添加功能

    public function add(){
    	#.判断提交方式
    	if(request()->isPost()){
	    	#.接收数据
	    	$postData=request()->param();
	    		
	    	#.过滤
	    	$validate=$this->validate($postData,'type',[]);
	    	if($validate !== true){
	    		$this->error($validate);
	    	}
	    	#.入库
	    	$sr=Type::create($postData);
	    	#.判断跳转
	    	if($sr){
	    		$this->success('添加成功',url('type/index'));
	    	}else{
	    		$this->error('添加失败');
	    	}	
    	}else{
    		#显示视图
    	return $this->fetch();
    	}
    	
    }

    // 删除功能

    public function delete($typeId){
           $sr=Type::where('type_id',$typeId)->delete();
        if($sr){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

     //删除功能

    public function edit($typeId){
        if(request()->isPost()){
            $postData=request()->post();
            $validate=$this->validate($postData,'type',[]);
            if($validate !== true){
                $this->error($validate);
            }
            $sr=Type::where('type_id',$typeId)->update($postData);
            if($sr){
                 $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }else{
            $types=Type::where('type_id',$typeId)->find();
        #显示视图
        return $this->fetch('edit',[
                'types'=>$types
            ]);
        }
        
    }

    
}
