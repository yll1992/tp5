<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Attribute;
use app\common\model\Type;


// 1、属性列表功能
class AttrController extends BaseController
{
    //显示

    public function index(){
    	// $attrs=Attribute::select();
    	$attrs=Attribute::join('type','type.type_id=attribute.type_id','left')->paginate(2);
    	#.显示视图
    	return $this->fetch('index',[
    			'attrs'=>$attrs
    		]);
    }


    // 属性添加

    public function add(){
        #.判断上传方式
    	if(request()->isPost()){
            #.接收数据
            $postData=request()->param();
            #.过滤
            $validate=$this->validate($postData,'Attr',[]);
            if($validate !==true){
                $this->error($validate);
            }
            #.入库
            $sr=Attribute::create($postData);
            #.判断跳转
            if($sr){
                $this->success('添加成功',url('Attr/index'));
            }else{
                $this->error('添加失败');
            }
    	}else{
    		$types=Type::select();
        	#.显示视图
        	return $this->fetch('add',[
    			'types'=>$types
    		]);
    	}
    	
    }

    // 属性删除

    public function delete($attrId){
        $sr=Attribute::where('attr_id',$attrId)->delete();
        if($sr){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    //商品属性接口（商品添加页使用）
    public function apiIndex(){
        #1.获取【商品类型】编号
        $typeId=request()->param('typeId', 0, 'intval');
        $typeId=$_POST['typeId'];
        $attrs=Attribute::where('type_id',$typeId)->select();
        return json(['state'=>1, 'data'=>$attrs]);
    }
}
