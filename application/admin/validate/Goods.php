<?php 
namespace app\admin\validate;

use think\Validate;

class Goods extends Validate
{
	//定义验证规则
	protected $rule = [
		'goods_name'           => 'require|unique:goods',
        'goods_number'         => 'require|regex:\d+',
		'goods_price'          => 'require|number',
		'goods_discount_price' => 'require|number'
	];

	//定义提示信息
	protected $message = [
		'goods_name.require'   => '商品名称必填',
		'goods_name.unique'    => '商品名称重复',
        'goods_number.require' => '商品库存必填',
        'goods_number.regex'   => '商品库存数量大于等于0',
        'goods_price.require'  => '商品价格必填',
        'goods_discount_price.require'  => '促销价必填',
        'goods_price.number'  => '商品价格必须是数字',
        'goods_discount_price.number'  => '商品促销价必须是数字'
	];

	//定义验证的场景
	protected $scene = [
		'add'  => ['goods_name', 'goods_number', 'goods_price', 'goods_discount_price'],
		'edit' => [               'goods_number', 'goods_price', 'goods_discount_price']
	];
}