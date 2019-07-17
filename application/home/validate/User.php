<?php 
namespace app\home\validate;

use think\Validate;

class User extends Validate
{
    //定义验证规则
    protected $rule = [
        'user_name' => 'require|min:2|max:6',
        'user_pwd'  => 'require|min:4|max:16',
       
    ];

    //定义提示信息
    protected $message = [
        'user_name.require' => '用户名称必填',
        'user_name.min' => '用户名称至少2个字',
        'user_name.max' => '用户名称最多6个字',
        'user_pwd.require' => '用户密码必填',
        
        'user_pwd.min' => '用户密码至少2个字',
        'user_pwd.max' => '用户密码最多6个字',
        
    ];

    //定义验证的场景
    protected $scene = [
        

    ];
}