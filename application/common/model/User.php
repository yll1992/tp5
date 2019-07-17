<?php

namespace app\common\model;

use think\Model;

class User extends Model
{
     //声明模型对应的表名（注：默认表名就是小写类名，特殊情况需要声明重写规则）
    protected $table = 'user';

    //声明插入数据时间字段自动填充
    protected $autoWriteTimestamp = true;
    //创建时间字段
    protected $createTime = 'created_at';
    //更新时间字段
    protected $updateTime = 'updated_at';


    /**
 * 检测用户
 * @param  array  $postData    条件数据
 * @param  string $sessionMark 标识（后台：userinfo，前台：frontUserinfo） 
 * @return bool
 */
public static function checkUser($postData, $sessionMark = 'userinfo')
{
    $user = self::where('user_name', $postData['user_name'])->find();
    // if (!$user) $this->error('用户不存在');
    // if (md5($postData['user_pwd'].'itcast!@#') != $user->user_pwd) $this->error('密码错误');
    if (!$user) return false;
    if (md5($postData['user_pwd'].'itcast!@#') != $user->user_pwd) return false;
    //保存用户信息进session
    \think\Session::set($sessionMark, $user);
    return true;
}

}
