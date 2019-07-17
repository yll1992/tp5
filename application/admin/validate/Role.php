<?php 
namespace app\admin\validate;

use think\Validate;

class Role extends Validate
{
    //定义验证规则
    protected $rule = [
        'role_name' => 'require|min:2|max:6',
       
    ];

    //定义提示信息
    protected $message = [
        'role_name.require' => '用户名称必填',
        'role_name.min' => '用户名称至少2个字',
        'role_name.max' => '用户名称最多6个字',
       
    ];

    //定义验证的场景
    protected $scene = [
    ];
}