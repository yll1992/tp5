<?php

namespace app\index\controller;

use think\Controller;
use app\common\model\T2;


class Test3Controller extends Controller
{
    //
    public function fn1(){
    	dump(request()->param());
    	echo request()->param('name').'<br />';
    	echo request()->param('name1','默认数据').'<br />';
    	echo request()->param('name','默认数据','filterData').'<br />';
    	echo '<hr>';

    	dump(input('param.'));
    	echo input('name').'<br />';
    	echo input('name1','默认数据').'<br />';
    	echo input('name','默认数据','filterData');
    }


    public function fn4(){
    	$t2s=T2::paginate(5);
    	return $this->fetch('t2s',['t2s'=>$t2s]);
	}
	

	public function fn5(){
		if(request()->isPost()){
				$file=request()->file('image');
				if($file){
					$info=$file->move(ROOT_PATH . 'public' . DS . 'uploads');
					if($info){
						     // 成功上传后 获取上传信息
							// 输出 jpg
							echo $info->getExtension() . '<hr />';
							// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
							echo $info->getSaveName() . '<hr />';
							// 输出 42a79759f284b767dfcb2a0197904287.jpg
							echo $info->getFilename() . '<hr />';
					}else{
						echo $file->getError();
					}
				}else{
					echo 6666;
				}
		}else{
			return $this->fetch('file');
		}
	}


	public function fn6(){
	    #判断是否post请求：是-处理上传文件，否-则加载表单视图
		if (Request::instance()->isPost())  {
			//步骤1：获取上传文件信息
			//注：单文件$file是对象
			//注：多文件$file是数组，数组中是对象
			$files = request()->file('image'); //相当于$_FILES['image']
			//步骤2：遍历上传
			foreach ($files as $file) {
				//判断文件是否为空
				if ($file) {
					//调用move方法上传
					$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
					//判断上传结果
					if ($info) {
						//输出上传文件名
						echo $info->getSaveName() . '<br />';
					}
				}
			}
		} else {
			return $this->fetch('file');
		}
		
	}
}
