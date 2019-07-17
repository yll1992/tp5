<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use app\common\model\T2;

class Test2Controller extends Controller
{
    #需求1：插入一条数据到t2表中
	#需求2：查询最新的2条数据

	public function fn1(){
		
		// $t2=T2::create(['uname'=>'aaa','content'=>'234']);
		// dump($t2);
		// echo $t2->id;


		#删，需求：用两种方式分别删除id=15和id=14的数据
		// $t2=T2::where('id',17)->delete();
		// dump($t2);
		// $t2=T2::destroy(16);
		// dump($t2);
		// // #改，需求：将id=13的数据改为mmm

		// $t2=T2::where('id',13)->update(['uname'=>'mmm']);
		// dump($t2);

		// $t2=T2::find(13);
		// $t2->uname='uuu';
		// $sr=$t2->save();
		// dump($sr);

		// 题目1：查询id=1
		// $t2=T2::where('id',1)->find();
		// // dump($t2);
		// echo $t2->uname;


		// 题目3：查询id>1

		// $t2s=T2::where('id','>',1)->select();
		// foreach($t2s as $v){
		// 	echo $v->uname.'<br/>';
		// }
		// 题目4：查询id=1并且uname=aa
		// $t2=T2::where('id',1)
		// 		->where('uname','aa')
		// 		->select();
		// 		foreach($t2 as $v){
		// 			echo $v->id;
		// 		}


		// 题目5：查询id=1或id=2.
		// $t2=T2::where('id',1)
		// 		->whereOr('id',2)
		// 		->select();
		// 		foreach($t2 as $v){
		// 			echo $v->uname.'<br/>';
		// 		}


		// #步骤1：执行SQL语句创建两个时间字段
		// alter table t2 add created_at int not null default 0;
		// alter table t2 add updated_at int not null default 0;
		// #步骤2：调用模型create方法插入数据.
		// $t2=T2::create([
		// 		'created_at'=>time(),
		// 		'updated_at'=>time()

		// 	]);
		// echo $t2->id;




		// #步骤3：查看数据，发现时间字段没有更新（原因：默认模型不自动托管时间字段）.
			// $t2=T2::create([
			// 	'uname'=>'2334',
			// 	'content'=>'745'

			// 	]);
			// echo $t2->id;

			// }

		// 模型名:: max(字段名);   //找指定字段最大值
		// 模型名::min(字段名);    //找指定字段最小值
		// 模型名::avg(字段名);     //求指定字段平均值
		// 模型名:: sum(字段名);   //求指定字段总和
		// 模型名::count();         //统计个数

		
		// echo T2::max('id').'<br />';
		// echo T2::min('id').'<br />';
		// echo T2::avg('id').'<br />';
		// echo T2::sum('id').'<br />';
		  // echo T2::count().'<br />';

		// $t2=T2::field('count(*) as sr')
		// 				->where('id','<',7)
		// 				->select();
		// 				foreach($t2 as $v){
		// 					echo $v->sr;
		// 				}

		// $t2=T2::field('sum(id) as sr')->select();
		// foreach ($t2 as $v){
		// 	echo $v->sr;
		// }

		$t2=new T2;
		dump($t2);
		$t2=T2::create([
				'uname'=>'sds',
				'content'=>'asd'

			]);
		dump($t2);


	}


	



}
