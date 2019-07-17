<?php
namespace app\common\model;

use think\Model;

class Goods extends Model
{
    //声明模型对应的表名（注：默认表名就是小写类名，特殊情况需要声明重写规则）
    protected $table = 'goods';

    //声明插入数据时间字段自动填充
    protected $autoWriteTimestamp = true;
    //创建时间字段
    protected $createTime = 'created_at';
    //更新时间字段
    protected $updateTime = 'updated_at';

    const YES = 1;


    protected static function init()
{
    self::afterInsert(function ($goods) {
        //逻辑代码
        $postData=request()->param();
       	$attrs = isset($postData['attr']) ? $postData['attr'] : [];
        // $attrs=isset($attrs)?'$attrs':[];
        
        foreach($attrs as $k=>$attr){
                    foreach($attr as $v){
                        GoodsAttr::create([
                                'goods_id'=>$goods->goods_id,
                                'attr_id'=>$k,
                                'attr_value'=>$v
                            ]);
                    }
                }
    });
}

public static function upload(){
	  $file = request()->file('img');
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    //后缀        $info->getExtension();
                    //目录&文件名 $info->getSaveName();
                    //文件名      $info->getFilename();
                    #生成缩略图
                    $smallLogo =  date('Ymd') . DS . 'thumb_'.$info->getFilename();
                    $image = \think\Image::open($file);
                    $image->thumb(80, 80)->save(ROOT_PATH . 'public' . DS . 'uploads' . DS . $smallLogo);
                    #保存方便create入库
                    $postData['goods_big_logo'] = $info->getSaveName();
                    $postData['goods_small_logo'] = $smallLogo;
                    return ['goods_big_logo'=>$info->getSaveName(),'goods_small_logo'=>$smallLogo];
                }else{
                    // 上传失败获取错误信息
                    // 
                    return false;
                }
            }
            return false;

	}
}