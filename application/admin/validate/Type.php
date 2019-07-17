<?php 
namespace app\admin\validate;

use think\Validate;

class Type extends Validate
{
	//定义验证规则
	protected $rule = [
		'type_name'           => 'require|unique:type',
       
	];

	//定义提示信息
	protected $message = [
		'type_name'   => '商品名称必填',
		'type_name'    => '商品名称重复',
       
	];

	//定义验证的场景
	protected $scene = [
		
	];
}