<?php 
namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
	    //定义验证规则
    protected $rule = [
        'cat_name' => 'require|min:2|max:6|unique:category',
        'is_show' => 'require|regex:[0-1]',
        'pid' => 'require|regex:\d{1,}'
    ];

    //定义提示信息
    protected $message = [
        'cat_name.require' => '分类名称必填',
        'cat_name.min' => '分类名称至少2个字',
        'cat_name.max' => '分类名称最多6个字',
        'cat_name.unique' => '分类名称不能重复',
        'is_show.require' => '状态必填',
        'is_show.regex' => '状态有瑕疵',
        'pid.require' => '父级分类必填',
        'pid.regex' => '父级分类有瑕疵'
    ];

    //定义验证的场景
    protected $scene = [
    ];
}