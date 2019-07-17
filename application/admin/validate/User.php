<?php 
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    //定义验证规则
    protected $rule = [
        'user_name' => 'require|min:2|max:6',
        'user_pwd'  => 'require|min:4|max:16',
        'user_pwd2'  => 'require|confirm:user_pwd',
        'role_id'  => 'require|regex:\d+',
        'captcha'   => 'require|captcha',
    ];

    //定义提示信息
    protected $message = [
        'user_name.require' => '用户名称必填',
        'user_name.min' => '用户名称至少2个字',
        'user_name.max' => '用户名称最多6个字',
        'user_pwd.require' => '用户密码必填',
        'user_pwd.unique' => '用户名已存在',
        'user_pwd.min' => '用户密码至少2个字',
        'user_pwd.max' => '用户密码最多6个字',
        'user_pwd2.require'  => '确定密码必填',
        'user_pwd2.confirm'  => '两次输入的密码不一致',
        'role_id.require'  => '所属角色必填',
        'role_id.regex'  => '所属角色错误',
        'captcha.require' => '验证码必填',
        'captcha.captcha' => '验证码错误'
    ];

    //定义验证的场景
    protected $scene = [
        'login'=>['user_id','user_pwd','captcha'],
        'add'=>['user_id'=>'require|min:2|max:6|unique:user','user_pwd','user_pwd2','role_id']
    ];
}