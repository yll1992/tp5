<?php

namespace app\common\model;

use think\Model;

class Role extends Model
{
      protected $table = 'role';

    //声明插入数据时间字段自动填充
    protected $autoWriteTimestamp = true;
    //创建时间字段
    protected $createTime = 'created_at';
    //更新时间字段
    protected $updateTime = 'updated_at';

    /**
 * 更改角色权限
 * @param  array $authIds 用户选择的所有权限IDs
 * @param  int   $roleId  当前角色ID
 * @return bool           受影响的行数
 */
public static function assignAuth($authIds, $roleId)
{
	// $auths = Auth::whereIn('auth_id', $postData['authIds'])->select();
	$auths = Auth::whereIn('auth_id', $authIds)->select();
	$temp = [];
	foreach ($auths as $auth) {
		$temp[] = $auth->auth_c . '@' . $auth->auth_a;
	}
	// $roleAuthIds = implode(',', $postData['authIds']);
	$roleAuthIds = implode(',', $authIds);
	$roleAuthCa = implode(',', $temp);//得根据权限ID去数据库找名字
	#4.更改角色表数据
	$rs = Role::where('role_id', $roleId)->update([
		'role_auth_ids' => $roleAuthIds,//'1,2,3,4',
		'role_auth_ca' => $roleAuthCa   //'控制器名@方法名,...,'
	]);
	return $rs;
}
}
