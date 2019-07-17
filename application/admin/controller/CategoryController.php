<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Category;


#2、列表功能
class CategoryController extends BaseController
{
    //列表首页
    public function index(){
    	$categorys=Category::select();
    	#无限极递归分类过滤
    	getTree($categorys);
    	#.显示视图
    	return $this->fetch('index',[
    			'categorys'=>$GLOBALS['tree']
    		]);
    }

    // 添加功能

    public function add(){
    	#.判断提交方式
    	if(request()->isPost()){
    		#.接收数据
    		$postData=request()->param();
    		#.过滤
    		$validate=$this->validate($postData,'Category',[]);
    		if($validate !== true){
    			$this->error($validate);
    		}
    		#.入库
    		$sr=Category::create($postData);
    		#.判断跳转
    		if($sr){
    			$this->success('添加成功',url('category/index'));
    		}else{
    			$this->error('添加失败');
    		}
    	}else{
    		$categorys=Category::select();
	    	#无限极递归分类过滤
	    	getTree($categorys);
	    	#.显示视图
	    	return $this->fetch('add',[
	    			'categorys'=>$GLOBALS['tree']
	    		]);
    	}
    	
    }

    // 删除功能

    public function delete($catId){
    	
    	$sr=Category::where('cat_id',$catId)->delete();
    	if($sr){
    		$this->success('删除成功');
    	}else{
    		$this->error('删除失败');
    	}
    }

    // 修改功能

    public function edit($catId){
        if(request()->isPost()){
            $postData=request()->post();
            $validate=$this->validate($postData,'Category',[]);
            if($validate !== true){
                $this->error($validate);
            }
            $sr=Category::where('cat_id',$catId)->update($postData);
            if($sr){
                $this->success('修改成功',url('category/index'));
        }else{
                $this->error('修改失败');
            }
        }else{
            $category=Category::where('cat_id',$catId)->find();
            $cat=Category::where('cat_id',$category->pid)->find();
            $categorys=Category::select();
            getTree($categorys);
            #显示视图
            return $this->fetch('edit',[
                    'categorys'=>$GLOBALS['tree'],
                    'category'=>$category,
                    'cat'=>$cat
                ]); 
        }
       
    }
}
