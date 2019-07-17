<?php

namespace app\common\model;

use think\Model;

class T2 extends Model
{
    //让模型自动托管
    protected $autoWriteTimestamp=true;

    //声明需要托管的字段（create_at和update_at）
    protected $createTime='created_at';
    protected $updateTime='updated_at';
}
