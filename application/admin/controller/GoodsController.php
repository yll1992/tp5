<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Goods;
use think\Validate;
use app\common\model\Category;
use app\common\model\Type;
use app\common\model\GoodsAttr;

class GoodsController extends BaseController
{
    //商品列表

    public function index(){
        #1.分页获取所有商品数据
        $goods=Goods::paginate(10);
        #2.显示视图
        return $this->fetch('index',['goods'=>$goods]);
    }


    // 商品模块（商品添加&上传）
    public function add(){
        #1.判断提交方式
        if(request()->isPost()){
            $postData=request()->param();
            // $attrs=$postData['attr'];
            // $attrs=isset($attrs)?'$attrs':[];
           unset($postData['attr']);
             #3.过滤（后面讲统一优化 先不管）
            //过滤
              $validate=$this->validate($postData,'Goods.add',[],true);
            if($validate!==true){
                $error=implode(',',$validate);
                $this->error($error);
            }
            $file=Goods::upload();
            if($file){
                $postData['goods_big_logo']=$file['goods_big_logo'];
                $postData['goods_small_logo']=$file['goods_small_logo'];
            }
            $sr=Goods::create($postData);
            if($sr){
              
                $this->success('添加成功',url('Goods/add'));
            }else{
                $this->error('添加失败',url('Goods/add'));
            }
        }else{
            $categorys=Category::select();
            getTree($categorys);
            $types=Type::select();
            #2.显示视图
            return $this->fetch('add',[
                    'categorys'=>$GLOBALS['tree'],
                    'types'=>$types
                ]);
        }

        
    }


     // 商品模块（商品删除）

    public function delete($goodsId,$currentPage){
        $sr=Goods::where('goods_id',$goodsId)->delete();
        
        if($sr){
            $goods=Goods::paginate(10);
            if($currentPage>$goods->lastPage()){
                $this->success('删除成功',url('Goods/index',['page'=>$goods->lastPage()]));
            }
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
       
    }


    // 商品模块（商品修改）
    public function edit($goodsId){
        #判断提交方式
        if(request()->isPost()){
            $postData=request()->post();
             #3.过滤（后面讲统一优化 先不管）
            //过滤
            $validate=$this->validate($postData,'Goods.edit',[],true);
            if($validate!==true){
                $error=implode(',',$validate);
                $this->error($error);
            }
            //上传图片（复制）
             $file=Goods::upload();
            if($file){
                $postData['goods_big_logo']=$file['goods_big_logo'];
                $postData['goods_small_logo']=$file['goods_small_logo'];
            }
            $sr=Goods::where('goods_id',$goodsId)->update($postData);
            if($sr){
                $this->success('修改成功',url('Goods/index'));
            }else{
                $this->error('修改失败');
            }
        }else{
            $goods=Goods::where('goods_id',$goodsId)->find();
            // dump($goods);
            #显示视图
            return $this->fetch('edit',['goods'=>$goods]);
        }
        
    }
}
