<?php
namespace app\admin\validate;

use think\Validate;

class Attr extends Validate
{
    //定义验证规则
    protected $rule = [
        'attr_name' => 'require|min:2|max:6',
        'type_id'   => 'require|regex:[1-9]\d*',
        'attr_sel'   => 'require',
        'attr_write'   => 'require'
    ];

    //定义提示信息
    protected $message = [
        'attr_name.require' => '属性名称必填',
        'attr_name.min' => '属性名至少2个字',
        'attr_name.max' => '属性名最多6个字',
        'type_id.require' => '商品类型必填',
        'type_id.regex' => '商品类型必须是数字',
        'attr_sel.require' => ' 单/多选属性必填',
        'attr_write.require' => '值录入方式必填'
    ];

    //定义验证的场景
    protected $scene = [
    ];
}