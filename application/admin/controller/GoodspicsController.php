<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\GoodsPics;

class GoodspicsController extends BaseController
{
    //相册添加&列表页面

    public function add($goodsId){
    	 #1.判断提交方式
        if (request()->isPost()) {
            // 是否上传成功（上传到临时目录中）
            $files = request()->file('img');
            //按个遍历移动（将临时目录中的文件移动到指定目录中）
            foreach($files as $file){
                // 定义上传路径
                $uploadPath = ROOT_PATH . 'public' . DS . 'uploads';
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move($uploadPath);
                if($info){
                    //移动成功（1-生成缩略图，2-保存到数据库中）
                    //生成缩略图
                    $temp = $uploadPath . DS;
                    $bigImg = date('Ymd') . DS . 'big_' . $info->getFilename();
                    $midImg = date('Ymd') . DS . 'mid_' . $info->getFilename();
                    $smaImg = date('Ymd') . DS . 'sma_' . $info->getFilename();
                    #生成缩略图
                    $image = \think\Image::open($file);
                    $image->thumb(800, 800, \think\Image::THUMB_CENTER)->save($temp . $bigImg);
                    $image = \think\Image::open($file);
                    $image->thumb(350, 350, \think\Image::THUMB_CENTER)->save($temp . $midImg);
                    $image = \think\Image::open($file);
                    $image->thumb(50, 50, \think\Image::THUMB_CENTER)->save($temp . $smaImg);
                    #保存数据库
                    GoodsPics::create([
                        'goods_id' => $goodsId,
                        'pics_ori' => $info->getSaveName(),

                        'pics_big' => $bigImg,
                        'pics_mid' => $midImg,
                        'pics_sma' => $smaImg,
                    ]);
                }else{
                    // 上传失败获取错误信息
                    //echo $file->getError();
                    $this->error($file->getError());
                }
            }
         
            #判断跳转
            $this->success('上传成功');
        }else{
        	// 获取图片
        	$goodspics=Goodspics::where('goods_id',$goodsId)->select();
        	// dump($goodspics);
        	#.显示视图
    		return $this->fetch('add',['goodspics'=>$goodspics]);
        }
    	
    }


    // 删除相册图片

    public function del($pics_id){
        $pic=GoodsPics::find($pics_id);
        dump($pic);
        if(!$pic){
            $this->error('您的操作有误，请刷新后重试.....');
        }
        $uploadPath=ROOT_PATH . 'public' . DS . 'uploads' . DS;
        @unlink($uploadPath.$pic->pics_ori);
        @unlink($uploadPath.$pic->pics_big);
        @unlink($uploadPath.$pic->pics_mid);
        @unlink($uploadPath.$pic->pics_sma);
    	$sr=Goodspics::where('pics_id',$pics_id)->delete();
    	if($sr){
    		$this->success('删除成功');
    	}else{
    		$this->error('删除失败');
    	}
    }
}
