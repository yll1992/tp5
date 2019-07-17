<?php 
namespace app\home\validate;

use think\Validate;

class Cart extends Validate
{
    //定义验证规则
    protected $rule = [
        'goods_id'=> 'require|regex:[1-9]\d*',
        'goods_number'  => 'require|regex:[1-9]\d*',
        'goods_attr_ids'=> 'require|regex:[0-9,]+'
    ];

    //定义提示信息
    protected $message = [
        'goods_id.require' => '商品编号必须填',
        'goods_id.regex' => '商品编号必须',

        'goods_number.require' => '商品数量必须',
        'goods_number.regex' => '商品数量是数字',

        'goods_attr_ids.require' => '商品属性必须',
        'goods_attr_ids.regex' => '请选择商品属性'
    ];

    //定义验证的场景
    protected $scene = [
        'delete'=>['goods_id','goods_attr_ids']
    ];
}