<?php 
namespace app\admin\validate;

use think\Validate;

class Auth extends Validate
{
    //定义验证规则
    protected $rule = [
    'auth_name'=>'require|min:2|max:6|unique:auth',
    'auth_pid'=>'require',
    'auth_c'=>'require',
    'auth_a'=>'require',
    ];

    //定义提示信息
    protected $message = [
     'auth_name.require'=>'名称必填',
     'auth_name.min'=>'名称最少2个字',
     'auth_name.max'=>'名称最多6个字',
     'auth_name.unique'=>'权限名称重复',
     'auth_pid.require'=>'父级权限必填',
     'auth_c.require'=>'控制器名必填',
     'auth_a.require'=>'方法必填',
    ];

    //定义验证的场景
    protected $scene = [
      
    ];
}